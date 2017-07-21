<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class trigger {

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
			
			$remove = isset($_POST[THEME_NAME.'_'.$field['label'].'_remove']) ? $_POST[THEME_NAME.'_'.$field['label'].'_remove'] : '';
			
			if ($remove) {

				/**
				 * An attachment has been triggered to be removed
				 */

				$result = self::remove($slug, $value, $field, $remove);
			}
			else {

				$result['value'] = $value;
				$result['error'] = '';
				$result['feedback'] = '';
			}

			return $result;
		}

		/**
		 * Removes attachments from the database and in their asset directories
		 *
		 * @param $slug 		- string database name
		 * @param $value 		- saved value in database
		 * @param $field 		- array of current field settings
		 * @param $remove 		- array with attachments to remove
		 *
		 */

		public static function remove($slug, $value, $field, $remove) {

			$removing = key($remove);
			
			if (is_array($value) && isset($value[0])) {

				$file = isset($value[0]['file']) ? $value[0]['file'] : '';
				$robots = isset($value[0]['robots']) ? $value[0]['robots'] : '';

				if (file_exists($file)) { unlink($file); }
				if (file_exists($robots)) { unlink($robots); }

				unset($value[0]);

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