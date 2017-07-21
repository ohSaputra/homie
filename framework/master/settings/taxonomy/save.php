<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace TaxonomyOptions;
	use ThemeOptions as ThemeOptions;

	// Save functions to validate and store form input

	class Save {

		public function __construct() {

			
		}

		/**
		 * Updates the database with posted value and returns it
		 *
		 * @param $slug 	- string database name
		 * @param $field 	- array of current field settings
		 * @param $id 		- id of current taxonomy
		 *
		 * @return mixed
		 */

		public static function save_term($slug, $field, $id) {

			$label = $field['label'];
			$value = get_term_meta($id, $label, true);
			
			$result = ThemeOptions\Validation::form_validation($slug, $value, $field);

			if ($value != $result['value'] && $result['error'] == '') {
				
				if (isset($field['target']) && is_array($field['target'])) {

					$slug = THEME_NAME.'_'.$field['target'][0];

					$update = get_option($slug);

					$update[$field['target'][1]] = $result['value'];
					update_option($slug, $update);
				}
				else {

					update_term_meta($id, $label, $result['value']);	
				}
			}

			if (isset($result['error']) && $result['error'] == $label) { 

				ThemeOptions\Validation::add_error($result);
			}
		}
	}
?>