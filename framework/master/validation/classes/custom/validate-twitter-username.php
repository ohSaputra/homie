<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a twitter username

	class validate_twitter_username {

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
			
			$name = empty($post) ? '' : preg_match('/^\@[\w]+$/', $post) === 0 ? '@'.strtolower(trim($post)) : strtolower(trim($post));
			
			$result['value'] = $name;
			$result['error'] = '';
			$result['feedback'] = '';

			return $result;
		}
	}
?>