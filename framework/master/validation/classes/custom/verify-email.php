<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class verify_email {

		/**
		 * Verifies that the input value is an email
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
			
			$email = empty($post) ? true : is_email($post);
			
			if ($email) {
				
				$result['value'] = $post;
				$result['error'] = '';
			}
			else {
				
				$result['value'] = $post;
				$result['error'] = $field['label'];
				$result['feedback'] = __('The submitted value is not a valid email.', 'admin translation');
			}

			return $result;
		}
	}
?>