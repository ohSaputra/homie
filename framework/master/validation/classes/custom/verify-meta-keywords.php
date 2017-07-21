<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class verify_meta_keywords {

		/**
		 * Verifies the keywords list to make sure it's in lowercase and it's a comma separated list
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
			
			$post = preg_split('/[\s,]+/', strtolower(str_replace('.', '', $post)));
				
			$result['value'] = empty($post) ? '' : implode(', ', array_filter($post));
			$result['error'] = '';

			return $result;
		}
	}
?>