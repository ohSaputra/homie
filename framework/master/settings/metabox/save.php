<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace MetaBoxOptions;
	use ThemeOptions as ThemeOptions;

	// Save functions to validate and store form input

	class Save {

		public function __construct() {

			
		}

		/**
		 * Organizes posted and saved values and updates the meta options
		 *
		 * @param $slug 	- string database name
		 * @param $field 	- array of current field settings
		 * @param $id 		- id of current metabox
		 *
		 */

		public static function save_meta_options($slug, $options, $id) {

			foreach ($options as $label => $fields) {
						
				foreach ($fields as $field) {

					if (isset($field['label'])) {

						$label = $field['label'];
						$value = get_post_meta($id, $label, true);

						$result = ThemeOptions\Validation::form_validation($slug, $value, $field);

						if ($value !== $result['value'] && $result['error'] == '') {
							
							if (isset($field['target']) && is_array($field['target'])) {

								$slug = THEME_NAME.'_'.$field['target'][0];

								$update = get_option($slug);

								$update[$field['target'][1]] = $result['value'];
								update_option($slug, $update);
							}
							else {

								update_post_meta($id, $label, $result['value']);	
							}
						}

						if (isset($result['error']) && $result['error'] == $label) { 

							ThemeOptions\Validation::add_error($result);
						}
					}
				}
			}
		}

		/**
		 * Returns the saved value of a field
		 *
		 * @param $field 	- array of current field settings
		 * @param $meta 	- array of page meta values
		 * @param $id 		- id of current metabox
		 *
		 * @return mixed
		 */

		public static function get_meta_value($field, $meta, $id) {

			$value = array_key_exists($field['label'], $meta) == false ? isset($field['value']) ? $field['value'] : '' : get_post_meta($id, $field['label'], true);

			return $value;
		}
	}
?>