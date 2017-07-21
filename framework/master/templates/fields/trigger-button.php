<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Trigger button options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (trigger button)
	// feedback			= The feedback to be displayed after a trigger action have been executed
	// description 		= The description of what this field will do for the user
	//

	class Trigger_Button_Field {

		/**
		 * Returns a button, which triggers a call function to be run on submit and displays the result as a file element
		 *
		 * @param $slug 	- string database name
		 * @param $field 	- array with current field settings
		 * @param $value 	- string or array of current field value
		 * @param $options 	- array with optional values ['class'], ['name'], ['id'], ['index']
		 *
		 * @return string $html
		 */

		public static function html($slug, $field, $value, $options = array()) {
				
			$output = '';

			$class = isset($options['class']) ? $options['class'] : 'regular-text';
			$id = isset($options['id']) ? $options['id'] : Field::get_label_name($field['label']);
			$name = isset($options['name']) ? $options['name'] : THEME_NAME.'_'.$field['label'];
			$tabindex = isset($options['index']) ? ' tabindex="'.$options['index'].'"' : '';
			$label = isset($field['action']) ? $field['action'] : $field['name'];

			if (!empty($value) && is_array($value) && min($value)) {

				$output .= self::file_output($slug, $field['label'], $id, $value[0]);
			}
			else {
				
				$output .= '<input type="submit" class="button-secondary action-button" name="action"'.$tabindex.' value="'.$label.'" />';
			}
			
			$output .= '<input type="hidden" class="'.$class.'" name="'.$name.'" id="'.$id.'" size="36" value="" />';
						
			return $output;
		}

		/**
		 * Returns a HTML tag and a remove button of a file
		 *
		 * @param $slug 	- string database name
		 * @param $field 	- string field name
		 * @param $id 		- string identification name
		 * @param $content 	- array with file content
		 *
		 * @return string $html
		 */

		public static function file_output($slug, $field, $id, $content) {

			$output = '';
			$path = pathinfo($content['url']);

			$time = $content['date'] + get_option('gmt_offset') * 3600;
			$date_format = get_option('date_format');
			$time_format = 'H:i';
			
			$date = date($date_format, $time);

			$name = strlen($content['name']) > 26 ? trim(substr($content['name'], 0, 26)).'...'.$path['extension'] : $content['name'];
			$url = site_url().str_replace(site_url(), '', $content['url']);

			$title = sprintf(__('%s crawled pages on %s', 'admin translation'), $content['pages'], date($date_format, $time).' at '.date($time_format, $time));

			$output .= '<div class="file-display"><a href="'.$url.'" class="file" target="_blank" title="'.$title.'">'.$name.'</a><input type="submit" class="button button-secondary remove-file" data-settings="'.$slug.'" data-field="'.$field.'" data-remove="'.$id.'" name="'.THEME_NAME.'_'.$field.'_remove['.$id.']" value="'.__('Delete', 'admin translation').'" /><em>'.$date.'</em></div>';
			
			return $output;
		}
	}
?>