<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class phone {

		/**
		 * Validates a phone number
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

			$pattern = '/^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/';
			$match = preg_match($pattern, $value);
			
			if (empty($match) ) {

				if (empty($value) && empty($field['required'])) {

					$result['value'] = $value;
					$result['error'] = '';
					$result['feedback'] = '';
				}
				else {

					$result['value'] = $value;
					$result['error'] = $field['label'];
					$result['feedback'] = sprintf(__('The submitted information is not a valid phone number, please check the %s field.', 'theme translation'), '<strong>'.strtolower($field['name'].'</strong>'));
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