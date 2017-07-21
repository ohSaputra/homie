<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Image upload field options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (image)
	// rendering 		= The rendering type of this field (single or multiple)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// filetypes 		= The supported filetypes that can be uploaded (an array of file types like png, jpg, gif or ico)
	// output 			= The image size of final image in width and height, requires an array of ['width'] and ['height']
	// description 		= The description of what this field will do for the user
	//

	class Image_Field {

		/**
		 * Returns an image upload field
		 *
		 * @param $slug 	- string database name
		 * @param $field 	- array with current field settings
		 * @param $value 	- string or array of current field value
		 * @param $options 	- array with optional values ['class'], ['name'], ['id'], ['index']
		 *
		 * @return string $html
		 */

		public static function html($slug, $field, $value, $options = array()) {
				
			$output = '';

			$class = isset($options['class']) ? $options['class'] : '';
			$id = isset($options['id']) ? $options['id'] : Field::get_label_name($field['label']);
			$name = isset($options['name']) ? $options['name'] : THEME_NAME.'_'.$field['label'];
			$tabindex = isset($options['index']) ? ' tabindex="'.$options['index'].'"' : '';

			$input = '<input type="file" class="'.$class.' regular-file" name="'.$name.'" id="'.$id.'"'.$tabindex.' /><input type="submit" name="upload" class="button control-button" value="'.__('Upload', 'admin translation').'" />';

			$output .= empty($value) ? $input : $field['rendering'] == 'multiple' ? $input : '';
			
			if (!empty($error)) {
				
				if (is_array($error) && isset($error['feedback']) && !empty($error['feedback'])) {
					
					$output .= '<span class="wrong">'.$error['feedback'].'</span>';
				}
				else {
					
					if (isset($field['filetypes'])) { $types = $field['filetypes']; } else { $types = array(''); }
									
					$filetypes = count($types) <= 1 ? reset($types) : join(', ', array_slice($types, 0, -1)).' or '.end($types);
					$filetypes = strtoupper($filetypes);
					$output .= '<span class="wrong">'.__('This is not a valid file, please make sure you are using any of the following file formats', 'admin translation').' '.str_replace('OR', 'or', $filetypes).'</span>';
				}
			}
			
			if (!empty($value) && is_array($value) && min($value)) {
				
				foreach ($value as $id => $content) {
					
					$output .= self::file_output($slug, $field['label'], $id, $content);
				}
			}

			return $output;
		}

		/**
		 * Returns a HTML tag and a remove button of a file
		 *
		 * @param $slug 	- string database name
		 * @param $field 	- string field name
		 * @param $id 		- string identification name
		 * @param $content 	- array with file content
		 * @param $date 	- string date format
		 *
		 * @return string $html
		 */

		public static function file_output($slug, $field, $id, $content) {

			$output = '';
			$extension = wp_check_filetype($content['url']);
			$file = '';
			
			$name = strlen($content['name']) > 26 ? trim(substr($content['name'], 0, 26)).'...'.$extension['ext'] : $content['name'];
			$url = site_url().str_replace(site_url(), '', $content['url']);
			
			$output .= '<div class="file-display"><a href="'.$url.'" class="file" target="_blank">'.$name.'</a><input type="submit" class="button button-secondary remove-file" data-settings="'.$slug.'" data-field="'.$field.'" data-remove="'.$id.'" name="'.THEME_NAME.'_'.$field.'_remove['.$id.']" value="'.__('Delete', 'admin translation').'" /><em>'.current_time(get_option('date_format'), get_option('gmt_offset')).'</em></div>';
			$output .= '<div class="file-display">'.$file.'</div>';
			
			return $output;
		}
	}
?>