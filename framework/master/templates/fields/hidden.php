<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;

	// Hidden text options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function is required for this field (could be a custom call function)
	// type				= The type name of this field (hidden)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// target 			= The theme option to target for saving the data, should be an array [theme option, field name]
	// description 		= The description of what this field will do for the user
	//
	
	class Hidden_Field {

		/**
		 * Returns a hidden text input field
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
			$target = isset($options['target']) ? $options['target'] : isset($field['target']) ? $field['target'] : '';
			
			if (!empty($value) && is_array($value) && empty($target)) {

				foreach ($value as $key => $content) {

					$output .= '<input type="hidden" class="'.$class.'" name="'.$name.'['.$key.']" id="'.$id.'-'.$key.'" size="36"'.$tabindex.' value="'.stripslashes($content).'" />';
				}
			}
			else {

				if (is_array($target) && count($target) >= 1) {

					$output .= '<input type="hidden" class="'.$class.'" name="'.THEME_NAME.'_target_option" size="36" value="'.THEME_NAME.'_'.$target[0].'" />';
					$output .= '<input type="hidden" class="'.$class.'" name="'.THEME_NAME.'_target_field" size="36" value="'.$target[1].'" />';
				}
				else {

					$output .= '<input type="hidden" class="'.$class.'" name="'.$name.'" id="'.$id.'" size="36"'.$tabindex.' value="'.stripslashes($value).'" />';
				}
			}
			
			return $output;
		}
	}
?>