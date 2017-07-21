<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class multiselect {

		/**
		 * Preserves the default value if the field is submitted empty
		 *
		 * @param $slug 	- string database name
		 * @param $value 	- saved value in database
		 * @param $field 	- array of current field settings
		 * @param $options 	- array with optional values to use for validation ['form']
		 *
		 * @return array
		 */

		public static function validate($slug, $value, $field, $options) {
			
	        $result['value'] = isset($_POST[THEME_NAME.'_'.$field['label']]) ? $_POST[THEME_NAME.'_'.$field['label']] : '';
			$result['error'] = '';
			$result['feedback'] = '';

			return $result;
		}
	}
?>