<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class color {

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

			$result['error'] = '';
			$result['value'] = '';
			
			$temp = isset($_POST[THEME_NAME.'_'.$field['label']]) ? str_replace('#', '', $_POST[THEME_NAME.'_'.$field['label']]) : str_replace('#', '', $value);
						
			$default = isset($field['value']) ? $field['value'] : '';
			$temp = empty($temp) ? $value : $temp;
			$result['value'] = empty($temp) ? '#'.$default : '#'.$temp;
						
			return $result;
		}
	}
?>