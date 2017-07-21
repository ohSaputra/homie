<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class preserve_default_value {

		/**
		 * Preserves the default value if the field is submitted empty
		 *
		 * @param $slug 	- string database name
		 * @param $value 	- saved value in database
		 * @param $field 	- array of current field settings
		 * @param $post 	- posted input value
		 * @param $options 	- array with optional values to use for validation ['form']
		 *
		 * @return array
		 */

		public static function validate($slug, $value, $field, $post, $options) {
							
			if ($post == '' || $post == 'null') {
						
				$result['value'] = $field['value'];
				$result['error'] = $field['label'];
				$result['feedback'] = sprintf(__("The %s field can not be empty.", 'admin translation'), '<span class="scope">'.$field['name'].'</span>');
			}
			else {
							
				$result['value'] = $post;
				$result['error'] = '';
				$result['feedback'] = '';
			}
			
			return $result;
		}
	}
?>