<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;

	// Save functions to validate and store form input

	class Save {
		
		public function __construct() {

			
		}
		
		/**
		 * Updates the database with posted value and returns it
		 *
		 * @param $field 	- array of current field settings
		 *
		 * @return mixed
		 */

		public static function save_page($slug, $field) {
						
			$options = get_option($slug);
			$label = $field['label'];
			$value = $options[$label];

			$result = Validation::form_validation($slug, $value, $field);
			
			if ($value != $result['value'] && $result['error'] == '') {
				
				$options[$label] = $result['value'];

				update_option($slug, $options);
			}

			if (isset($result['error']) && $result['error'] == $label) { 

				Validation::add_error($result);
			}
			
			return $result['value'];
		}

		/**
		 * Updates the database with default value and returns it
		 *
		 * @param $temp 	- array of new posted values
		 * @param $field 	- array of current field settings
		 *
		 * @return mixed
		 */

		public static function set_default_value($slug, $temp, $field) {
						
			$options = get_option($slug);
			$label = $field['label'];

			if (empty($options)) {
				
				$value = $field['value'];
				
				update_option($slug, $temp);
			}
			else {
								
				if (empty($options[$label])) {
					
					$options += array($label => isset($field['value']) ? $field['value'] : '');
					
					update_option($slug, $options);
				}
				
				$value = $options[$label];
			}

			return $value;
		}
		
	}
?>