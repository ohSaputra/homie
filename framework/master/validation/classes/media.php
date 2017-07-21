<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class media {

		/**
		 * Validates attachment added from the media library
		 *
		 * @param $slug 	- string database name
		 * @param $value 	- saved value in database
		 * @param $field 	- array of current field settings
		 * @param $options 	- array with optional values to use for validation ['form']
		 *
		 * @return array
		 */
		
		public static function validate($slug, $value, $field, $options) {

			$form = isset($options['form']) ? $options['form'] : '';
			$upload = $form === 'widget' ? (isset($value[$field['label']]) ? $value[$field['label']] : '') : (isset($_POST[THEME_NAME.'_'.$field['label']]) ? $_POST[THEME_NAME.'_'.$field['label']] : '');
			$rendering = isset($field['rendering']) ? $field['rendering'] : '';

			if ($upload) {

				if ($rendering == 'multiple' && is_array($upload) && count($upload) >= 2) {

					$temp = array();

					foreach ($upload as $key => $content) {

						$image = self::upload($content, $field);
						array_push($temp, $image);
					}

					$result['value'] = array_merge(array_filter($temp));
					$result['error'] = '';
				}
				else {

					$upload = is_array($upload) ? array_merge($upload) : $upload;

					$image = self::upload($upload[0], $field);

					$result['value'] = empty($image) ? '' : array(0 => $image);
					$result['error'] = '';
				}
			}
			else {

				$result['value'] = $value;
				$result['error'] = '';
			}
			
			return $result;
		}

		/**
		 * Performs the upload handling of an attachment
		 *
		 * @param $upload		- array of posted input value
		 * @param $field 		- array of current field settings
		 *
		 * @return array
		 */

		public static function upload($upload, $field) {

			$id = isset($upload['id']) ? $upload['id'] : '';
			$image = wp_attachment_is_image($id);

			if ($image) {

				$media = array();
				$meta = wp_get_attachment_metadata($id);

				$media['id'] = $id;
				$media['url'] = wp_get_attachment_url($id);
				$media['alt'] = get_post_meta($id, '_wp_attachment_image_alt', true);
				$media['width'] = $meta['width'];
				$media['height'] = $meta['height'];
				$media['ratio'] = $meta['width'] / $meta['height'];
				$media['output'] = isset($field['output']) ? $field['output'] : '';
				$media['lazyload'] = isset($field['lazyload']) ? $field['lazyload'] : true;

				$media['crop']['x'] = $upload['crop']['x'];
				$media['crop']['y'] = $upload['crop']['y'];
				$media['crop']['w'] = $upload['crop']['w'];
				$media['crop']['h'] = $upload['crop']['h'];

				$temp = array('id' => $media['id'], 'url' => $media['url'], 'alt' => $media['alt'], 'width' => $media['width'], 'height' => $media['height'], 'ratio' => $media['ratio'], 'lazyload' => $media['lazyload'], 'output' => $media['output'], 'crop' => $media['crop']);
			}
			else {

				$temp = '';
			}
			
			return $temp;
		}
	}
?>