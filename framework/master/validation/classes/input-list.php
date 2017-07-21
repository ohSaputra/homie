<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class inputlist {

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

			$add = isset($_POST[THEME_NAME.'_'.$field['label']]) ? $_POST[THEME_NAME.'_'.$field['label']] : '';
			$remove = isset($_POST[THEME_NAME.'_'.$field['label'].'_remove']) ? $_POST[THEME_NAME.'_'.$field['label'].'_remove'] : '';

			if ($add) {

				if (empty($value)) {

					$result['value'] = array('0' => $add);
					$result['error'] = '';
				}
				else {

					$result['value'] = array_merge($value, array('0' => $add));
					$result['error'] = '';
				}
			}

			if ($remove) {

				$result = self::remove($slug, $value, $field, $remove);			
			}
			else {

				$result['value'] = isset($result['value']) ? $result['value'] : $value;
				$result['error'] = '';
			}
			
			return $result;
		}

		/**
		 * Removes variables from the database
		 *
		 * @param $slug 		- string database name
		 * @param $value 		- saved value in database
		 * @param $field 		- array of current field settings
		 * @param $remove 		- array with attachments to remove
		 *
		 */

		public static function remove($slug, $value, $field, $remove) {

			$removing = key($remove);

			if (isset($value[$removing])) {

				unset($value[$removing]);

				$value = array_values($value);

				$result['value'] = $value;
				$result['error'] = '';
			}
			else {

				$result['value'] = $value;
				$result['error'] = '';
			}

			return $result;
		}
	}
?>