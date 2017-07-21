<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class file {

		/**
		 * Validates an uploaded attachment to make sure the file is accepted
		 *
		 * @param $slug 	- string database name
		 * @param $value 	- saved value in database
		 * @param $field 	- array of current field settings
		 * @param $options 	- array with optional values to use for validation ['form']
		 *
		 * @return array
		 */
		
		public static function validate($slug, $value, $field, $options) {
			
			$upload = isset($_FILES[THEME_NAME.'_'.$field['label']]) ? $_FILES[THEME_NAME.'_'.$field['label']] : '';
			$remove = isset($_POST[THEME_NAME.'_'.$field['label'].'_remove']) ? $_POST[THEME_NAME.'_'.$field['label'].'_remove'] : '';
			$error = isset($upload['error']) ? $upload['error'] : '';

			if ($upload && $error != 4) {

				/**
				 * An attachment has been uploaded so we'll check supported file types 
				 */

				$file = $_FILES[THEME_NAME.'_'.$field['label']];
				$extension = wp_check_filetype($file['name']);

				if (isset($field['filetypes']) && in_array(strtolower($extension['ext']), $field['filetypes'])) {
					
					$result = self::upload($value, $field, $file, $extension);

				}
				else {

					if (is_array($value) && count($value) >= 1) { $result['value'] = $value; } else { $result['value'] = ''; }
				
					$result['error'] = $field['label'];
					$result['feedback'] = sprintf(__("The uploaded file type %s is not supported, please make sure the file is in one of the following formats (%s).", 'admin translation'), '<span class="scope">'.$extension['ext'].'</span>', '<span class="strong">'.get_comma_separated_list($field['filetypes'], 'or').'</span>');
				}

			}

			if ($remove) {

				/**
				 * An attachment has been triggered to be removed
				 */

				$result = self::remove($slug, $value, $field, $remove);
			}
			else {

				/**
				 * Nothing has changed and we leave it as it is
				 */

				$result['value'] = isset($result['value']) ? $result['value'] : $value;
				$result['error'] = isset($result['error']) ? $result['error'] : '';
				$result['feedback'] = isset($result['feedback']) ? $result['feedback'] : '';
			}

			return $result;
		}

		/**
		 * Performs the upload handling of an attachment
		 *
		 * @param $value		- saved value in database
		 * @param $field 		- array of current field settings
		 * @param $file			- array of posted input value
		 * @param $extension 	- file extension if posted attachment
		 *
		 * @return array
		 */

		public static function upload($value, $field, $file, $extension) {

			update_option(THEME_NAME.'_uploaded_form_content', $file);
			add_filter('upload_dir', array(__CLASS__, 'uploads_path'));
			
			$override['test_form'] = false;
			$uploaded_file = wp_handle_upload($file, $override);
			$uploaded_file['name'] = str_replace('.'.$extension['ext'], '', $file['name']);
			
			remove_filter('upload_dir', array(__CLASS__, 'uploads_path'));
			update_option(THEME_NAME.'_uploaded_form_content', '');

			if (isset($uploaded_file['error'])) {

				if (is_array($value) && count($value) >= 1) { $result['value'] = $value; } else { $result['value'] = ''; }
				
				$result['error'] = $field['label'];
				$result['feedback'] = $uploaded_file['error'];
			}
			else {

				if (in_array($file['type'], array('image/jpeg', 'image/gif', 'image/png', 'image/ico', 'image/x-icon'))) {

					$size = getimagesize($uploaded_file['file']);

					$file['width'] = $size[0];
					$file['height'] = $size[1];
					$file['ratio'] = $size[0] / $size[1];
					$file['output'] = isset($field['output']) ? $field['output'] : '';
				}
				else {

					$file['width'] = '';
					$file['height'] = '';
					$file['ratio'] = '';
					$file['output'] = '';
				}

				if ($field['rendering'] == 'multiple' && is_array($value)) {
				
					$push = array(count($value) => array('url' => stripslashes(str_replace(site_url(), '', $uploaded_file['url'])), 'file' => $uploaded_file['file'], 'name' => $file['name'], 'width' => $file['width'], 'height' => $file['height'], 'ratio' => $file['ratio'], 'size' => $file['size'], 'date' => time(), 'output' => $file['output']));
					$result['value'] = array_merge($value, $push);
					$result['error'] = '';
				}
				else {
					
					if (is_array($value)) { $old_file = isset($value[0]['file']) ? $value[0]['file'] : ''; if (file_exists($old_file)) { unlink($old_file); } }
					
					$result['value'] = array('0' => array('url' => stripslashes(str_replace(site_url(), '', $uploaded_file['url'])), 'file' => $uploaded_file['file'], 'name' => $file['name'], 'width' => $file['width'], 'height' => $file['height'], 'ratio' => $file['ratio'], 'size' => $file['size'], 'date' => time(), 'output' => $file['output']));
					$result['error'] = '';
				}
			}

			return $result;
		}

		/**
		 * Removes attachments from the database and in their asset directories
		 *
		 * @param $slug 		- string database name
		 * @param $value 		- saved value in database
		 * @param $field 		- array of current field settings
		 * @param $remove 		- array with attachments to remove
		 *
		 */

		public static function remove($slug, $value, $field, $remove) {

			$removing = key($remove);

			if (isset($value[$removing])) {

				$file = isset($value[$removing]['file']) ? $value[$removing]['file'] : '';

				if (file_exists($file)) {

					unlink($file);
				}

				unset($value[$removing]);

				$result['value'] = $value;
				$result['error'] = '';
			}
			else {

				$result['value'] = $value;
				$result['error'] = '';
			}

			return $result;
		}

		/**
		 * Relocate attachement to different folders depending on file type
		 *
		 * @param $field 		- array with folder paths
		 *
		 * @return array
		 */

		public static function uploads_path($upload) {
			
			$file = get_option(THEME_NAME.'_uploaded_form_content');
			$type = $file['type'];
			
			switch($type) {
				case 'image/jpeg':
				
					$upload['subdir'] = '/assets/images';
					
				break;
				case 'image/gif':
				
					$upload['subdir'] = '/assets/images';
					
				break;
				case 'image/png':
				
					$upload['subdir'] = '/assets/images';
					
				break;
				case 'image/ico':
				
					$upload['subdir'] = '/assets/images';
					
				break;
				case 'image/x-icon':
				
					$upload['subdir'] = '/assets/images';
					
				break;
				case 'text/css':
				
					$upload['subdir'] = '/assets/style';
					
				break;
				case 'application/x-javascript':
				
					$upload['subdir'] = '/assets/script';
					
				break;
				default:
					
					$upload['subdir'] = '/assets/files';
					
				break;
			}
			
			$upload['path'] = $upload['basedir'].$upload['subdir'];
			$upload['url'] = $upload['baseurl'].$upload['subdir'];
			
			return $upload;
		}
	}
?>