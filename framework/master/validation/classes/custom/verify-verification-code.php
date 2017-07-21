<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class verify_verification_code {

		/**
		 * Verifies that the input field does not contains a meta tag
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
			
			if (strtolower(substr($post, 0, 5)) === '<meta') {
			
				preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', stripslashes($post), $matches);
				
				$result['value'] = $matches[2][0];
				$result['error'] = '';
			}
			else if (strlen($post) != strlen(strip_tags($post))) {
							
				$result['value'] = htmlspecialchars($post);
				$result['error'] = $field['label'];
			}
			else {
				
				$result['value'] = empty($post) ? '' : $post;
				$result['error'] = '';
			}
			
			return $result;
		}
	}
?>