<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class prevent_empty_number {

		/**
		 * Prevents empty numbers in fields that was submitted empty
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
			
			if ($post === '' || !is_numeric($post) || is_numeric($post) && $post == 0) {
				
				$result['value'] = $value;
				$result['error'] = $field['label'];
			}
			else {
							
				$result['value'] = $post;
				$result['error'] = '';
			}

			return $result;
		}
	}
?>