<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class verify_google_analytics_code {

		/**
		 * Verifies the google analytics code and returns the ID
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
			
			if (preg_match('/ua-\d{4,9}-\d{1,4}/i', strval($post))) {
			
				preg_match_all('/ua-\d{4,9}-\d{1,4}/i', stripslashes($post), $matches);
				
				$result['value'] = $matches[0][0];
				$result['error'] = '';
			}
			else {
				
				if (strlen($post) != strlen(strip_tags($post))) {
								
					$result['value'] = htmlspecialchars($post);
					$result['error'] = $field['label'];
				}
				else {
					
					$result['value'] = empty($post) ? '' : $post;
					$result['error'] = empty($post) ? '' : $field['label'];
				}
			}

			return $result;
		}
	}
?>