<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class generate_xml_sitemap {

		/**
		 * Generates an xml sitemap of all available pages and enable a link for download
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
			
			if (isset($_POST['action']) && $_POST['action'] === $field['name']) {

				$field = $field['label'];

				$sitemap = new \ThemeOptions\XML_Sitemap($slug, $field);
				$output = $sitemap->create();

				$result['value'] = $output['value'];
				$result['error'] = $output['error'];
				$result['feedback'] = $output['feedback'];
			}
			else if (isset($_POST[THEME_NAME.'_target_option']) && isset($_POST[THEME_NAME.'_target_field'])) {

				$slug = $_POST[THEME_NAME.'_target_option'];
				$field = $_POST[THEME_NAME.'_target_field'];
				
				$sitemap = new \ThemeOptions\XML_Sitemap($slug, $field);
				$output = $sitemap->create();

				$result['value'] = $output['value'];
				$result['error'] = $output['error'];
				$result['feedback'] = $output['feedback'];
			}
			else {

				$result['value'] = empty($post) ? '' : $value;
				$result['error'] = '';
			}

			return $result;
		}
	}
?>