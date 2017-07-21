<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Generates form fields from custom theme options

	class Field {

		private	$slug;
		private	$options;
		private	$page;
		private	$data;

		public function __construct($slug, $page = null) {

			$this->slug = $slug;
			$this->page = $page;
		}

		/**
		 * Returns a form input field or field component based on request
		 *
		 * @param $slug 	- string database name
		 * @param $field 	- array with current field settings
		 * @param $value 	- string or array of current field value
		 * @param $options 	- array with optional values ['class'], ['name'], ['id'], ['index'], ['form']
		 *
		 * @return string $html
		 */

		public static function get_field($slug, $field, $value, $options = array()) {
			
			switch ($field['type']) {

				case 'text':

					return Text_Field::html($slug, $field, $value, $options);
					
				break;
				case 'textarea':

					return Textarea_Field::html($slug, $field, $value, $options);

				break;
				case 'checkbox':

					return Checkbox_Field::html($slug, $field, $value, $options);

				break;
				case 'radio':

					return Radio_Field::html($slug, $field, $value, $options);

				break;
				case 'radio option':

					return Radio_Option_Field::html($slug, $field, $value, $options);

				break;
				case 'select':

					return Select_Field::html($slug, $field, $value, $options);

				break;
				case 'select list':

					return Select_List_Field::html($slug, $field, $value, $options);

				break;
				case 'seo preview':

					return SEO_Field::html($slug, $field, $value, $options);

				break;
				case 'color picker':

					return Color_Field::html($slug, $field, $value, $options);

				break;
				case 'file':

					return File_Field::html($slug, $field, $value, $options);

				break;
				case 'image':

					return Image_Field::html($slug, $field, $value, $options);

				break;
				case 'media':

					return Media_Field::html($slug, $field, $value, $options);

				break;
				case 'number':

					return Number_Field::html($slug, $field, $value, $options);
					
				break;
				case 'phone':

					return Phone_Field::html($slug, $field, $value, $options);
					
				break;
				case 'url':

					return Url_Field::html($slug, $field, $value, $options);
					
				break;
				case 'action':
				case 'action export':

					return Action_Field::html($slug, $field, $value, $options);

				break;
				case 'trigger':

					return Trigger_Field::html($slug, $field, $value, $options);

				break;
				case 'trigger button':

					return Trigger_Button_Field::html($slug, $field, $value, $options);

				break;
				case 'input list':

					return Input_List_Field::html($slug, $field, $value, $options);

				break;
				case 'matrix':

					return Matrix_Field::html($slug, $field, $value, $options);

				break;
				case 'google font':

					return Font_Field::html($slug, $field, $value, $options);

				break;
				case 'font preview':
				
					return Font_Preview_Field::html($slug, $field, $value, $options);

				break;
				case 'gmap':

					return Gmap_Field::html($slug, $field, $value, $options);

				break;
				case 'hidden':

					return Hidden_Field::html($slug, $field, $value, $options);

				break;
			}
		}

		/**
		 * Returns a label name that is more suitable for CSS and JavaScript
		 *
		 * @param $label 	- string name of current field
		 *
		 * @return string
		 */

		public static function get_label_name($label) {

			$label = THEME_NAME.'-'.str_replace('_', '-', $label);
			
			return $label;
		}

		/**
		 * Returns an error message class if there's an error on a posted form
		 *
		 * @param $label 	- string name of current field
		 *
		 * @return string $html
		 */

		public static function get_label_error($label) {
			
			$error = get_option(THEME_NAME.'_error_tracking');
			
			return (isset($error['error']) && $error['error'] == $label) ? ' class="error"' : '';
		}

		/**
		 * Returns an alert message box with feedback on a posted form 
		 *
		 * @return string $html
		 */

		public static function get_form_feedback() {

			$output = '';
			$screen = get_current_screen();
			$error = get_option(THEME_NAME.'_error_tracking');
			
			if (empty($error)) :
			
				if ($screen->post_type === '' && $screen->taxonomy === '') :
					
					$output .= isset($_POST['updating']) ? '<div class="notice updated alert-message fadeout" id="message"><p><strong>'.__('Options saved.', 'admin translation').'</strong></p></div>'."\n" : '';

				else : 

					$output .= '';

				endif;

			else : 

				if ($screen->post_type === '' && $screen->taxonomy === '') :
					
					$output .= isset($_POST['updating']) ? '<div class="notice error alert-message" id="message"><p><strong>'.(isset($error['feedback']) ? $error['feedback'] : __('Something went wrong, please correct the errors below.', 'admin translation')).'</strong></p></div>'."\n" : '';

				else : 

					$output .= '<div class="notice error alert-message" id="message"><p><strong>'.(isset($error['feedback']) ? $error['feedback'] : __('Something went wrong, please correct the errors below.', 'admin translation')).'</strong></p></div>'."\n";

				endif;

			endif;

			return $output;
		}
	}
?>