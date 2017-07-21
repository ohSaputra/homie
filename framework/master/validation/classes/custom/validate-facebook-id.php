<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class validate_facebook_id {

		/**
		 * Validates a Facebook app ID and make sure it's 15 digits
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
			
			if (empty($post)) {

				$result['value'] = '';
				$result['error'] = '';
			}
			else {

				if (is_numeric($post) && strlen((string) $post) === 15) {

					$result['value'] = $post;
					$result['error'] = '';
				}
				else {

					$result['value'] = $post;
					$result['error'] = $field['label'];
					$result['feedback'] = __('Please check that your facebook app ID contains a 15 digit number.', 'admin translation');
				}
			}
			
			return $result;
		}
	}
?>