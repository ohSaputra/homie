<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class number {

		/**
		 * Validates a number
		 *
		 * @param $slug 	- string database name
		 * @param $value 	- saved value in database
		 * @param $field 	- array of current field settings
		 * @param $options 	- array with optional values to use for validation ['form']
		 *
		 * @return array
		 */

		public static function validate($slug, $value, $field, $options) {

			$temp = $_POST[THEME_NAME.'_'.$field['label']];
			$value = empty($temp) ? $value : $temp;

			$pattern = '^[0-9\.-]+$';
			$match = preg_match('#'.$pattern.'#isu', $value);

			if (empty($match) ) {

				if (empty($value) && empty($field['required'])) {

					$result['value'] = $value;
					$result['error'] = '';
					$result['feedback'] = '';
				}
				else {

					$result['value'] = $value;
					$result['error'] = $field['label'];
					$result['feedback'] = sprintf(__('The submitted information is not a valid number, please check the %s field.', 'theme translation'), '<strong>'.strtolower($field['name'].'</strong>'));
				}
			}
			else {

				$result['value'] = $value;
				$result['error'] = '';
				$result['feedback'] = '';
			}

			return $result;
		}
	}
	
?>