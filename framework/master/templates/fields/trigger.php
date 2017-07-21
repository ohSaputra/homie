<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Trigger field options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (trigger)
	// match 			= The selection that needs to be matched for the action to be triggered
	// options			= The two options available (a selectbox array)
	// description 		= The description of what this field will do for the user
	//
	
	class Trigger_Field {

		/**
		 * Returns a select field, which triggers a call function to be run after form submit and displays the result as a file element
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

			$match = !empty($value) && is_array($value) ? $field['match'] : $value;
			
			$output .= '<select class="'.$class.'" name="'.$name.'" id="'.$id.'"'.$tabindex.'>';
			
			if (!empty($field['options']) && is_array($field['options'])) {
				
				$output .= '<option value="0">'.____('- System default', 'admin translation').'</option>';
				
				foreach ($field['options'] as $id => $option) {
					
					if (is_array($option)) { $content = $option[1]; $option = $option[0]; } else { $content = $id + 1; }
					if ($match == $content) { $selected = ' selected="selected"'; } else  { $selected = ''; } 
					
					$output .= '<option value="'.$content.'"'.$selected.'>'.$option.'</option>';
				}
			}
			else {
				
				$output .= '<option value="0">'.____('- System default', 'admin translation').'</option>';
			}
			
			$output .= '</select>';
			
			if (!empty($value) && is_array($value)) {
				
				$output .= get_file_content_admin_tag($settings_name, $field['label'], 0, $value[0], 'd F, Y, H:i:s');
			}

			$output .= '';
			
			return $output;
		}
	}
?>