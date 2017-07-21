<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;

	// Validates form inputs from custom theme options

	class Validation {

		private	$slug;
		private	$options;
		private	$data;

		public function __construct() {

			
		}

		/**
		 * Validates posted form values and returns a new value to be updated in the database
		 *
		 * @param $slug 	- string database name
		 * @param $value 	- saved value in database
		 * @param $field 	- array of current field settings
		 * @param $options 	- array with optional values to use for validation ['form']
		 *
		 * @return array
		 */

		public static function form_validation($slug, $value, $field, $options = array()) {
						
			$custom = $field['validation'];
			$type = $field['type'];

			switch ($type) {

				case 'file':

					$result = Validate\file::validate($slug, $value, $field, $options);

				break;
				case 'image':
					
					$result = Validate\image::validate($slug, $value, $field, $options);
										
				break;
				case 'number':
					
					$result = Validate\number::validate($slug, $value, $field, $options);
										
				break;
				case 'phone':
					
					$result = Validate\phone::validate($slug, $value, $field, $options);
										
				break;
				case 'url':
					
					$result = Validate\url::validate($slug, $value, $field, $options);
										
				break;
				case 'media':
					
					$result = Validate\media::validate($slug, $value, $field, $options);
					
				break;
				case 'color picker':
				
					$result = Validate\color::validate($slug, $value, $field, $options);
					
				break;
				case 'matrix':
					
					$result = Validate\matrix::validate($slug, $value, $field, $options);
					
				break;
				case 'trigger':
				case 'trigger button':
				
					$result = Validate\trigger::validate($slug, $value, $field, $options);
					
				break;
				case 'checkbox':
				case 'select list':
				
					$result = Validate\multiselect::validate($slug, $value, $field, $options);
					
				break;
				case 'input list':
					
					$result = Validate\inputlist::validate($slug, $value, $field, $options);
					
				break;
				case 'hidden':
					
					$value = empty($field['value']) ? isset($_POST[THEME_NAME.'_'.$field['label']]) ? $_POST[THEME_NAME.'_'.$field['label']] : $value : $field['value'];

					$result['value'] = $value;
					$result['error'] = '';
					
				break;
				case 'file':
									
					$result['value'] = $value;
					$result['error'] = '';
					
				break;
				default:
				
					if (isset($_POST[THEME_NAME.'_'.$field['label']])) {
						
						$result['value'] = $_POST[THEME_NAME.'_'.$field['label']];
						$result['error'] = '';
					}
					else {
						
						$result['value'] = '';
						$result['error'] = '';
					}
					
				break;
			}
						
			if (! empty($custom) ) {
				
				$result = self::custom_validation($slug, $value, $field, $result, $options);
			}
			
			return $result;
		}

		/**
		 * Validates posted form values with a predefined function
		 *
		 * @param $slug 	- string database name name
		 * @param $value 	- saved value in database
		 * @param $field 	- array of current field settings
		 * @param $result 	- array of posted input value
		 * @param $options 	- array with optional values to use for validation ['form']
		 *
		 * @return array
		 */

		public static function custom_validation($slug, $value, $field, $result, $options) {

			$function = $field['validation'];
			$post = $result['value'];

			switch ($function) {

				case 'preserve_default_value':
					
					$result = Validate\preserve_default_value::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'prevent_empty_value':
				
					$result = Validate\prevent_empty_value::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'prevent_empty_number':
				
					$result = Validate\prevent_empty_number::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'verify_email':
					
					$result = Validate\verify_email::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'verify_email_list':
					
					$result = Validate\verify_email_list::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'verify_meta_keywords':
				
					$result = Validate\verify_meta_keywords::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'verify_google_analytics_code':
				
					$result = Validate\verify_google_analytics_code::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'verify_verification_code':
				
					$result = Validate\verify_verification_code::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'verify_gmap_location':
					
					$result = Validate\verify_gmap_location::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'validate_facebook_id':
				
					$result = Validate\validate_facebook_id::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'validate_twitter_username':
				
					$result = Validate\validate_twitter_username::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'generate_xml_sitemap':
				
					$result = Validate\generate_xml_sitemap::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'remove_html_special_chars':
				
					$result = Validate\remove_html_special_chars::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'run_flush_rewrite_rules':
					
					$result = Validate\run_flush_rewrite_rules::validate($slug, $value, $field, $post, $options);
					
				break;
				case 'set_article_reading_time':
					
					$result = Validate\set_article_reading_time::validate($slug, $value, $field, $post, $options);
					
				break;
				default:
					
					$result['value'] = $result['value'];
					$result['error'] = $field['label'];
					$result['feedback'] = sprintf(__('The custom class %s used for validation is missing.', 'admin translation'), '<span class="scope">'.$field['validation'].'</span>');
										
				break;
			}

			return $result;
		}

		/**
		 * Adds a field with error to the error tracking database
		 *
		 * @param $result 	- array of validated input value
		 */

		public static function add_error($result) {
			
			update_option(THEME_NAME.'_error_tracking', $result);
		}

		/**
		 * Reset all errors in the error tracking database
		 *
		 */

		public static function reset_error() {
			
			update_option(THEME_NAME.'_error_tracking', '');
		}
	}
?>