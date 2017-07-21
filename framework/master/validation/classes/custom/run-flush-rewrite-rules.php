<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class run_flush_rewrite_rules {

		/**
		 * Flushing and removes permalink settings rules and recreates them
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
			
			$result['value'] = $post;
			$result['error'] = '';

			flush_rewrite_rules();

			return $result;
		}
	}
?>