<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Input list options available
	//
	// name 			= The label name visible for the user
	// button 			= The button name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (input list)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// description 		= The description of what this field will do for the user
	//

	class Input_List_Field {

		/**
		 * Returns an input list field that outputs variable names
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
			
			$action = (isset($field['button'])) ? $field['button'] : __('Add', 'admin translation');
			
			$output .= '<div class="input-list-field">';
			$output .= '<input type="text" class="'.$class.' half-text" name="'.$name.'" id="'.$id.'" size="36"'.$tabindex.' value="" /><input type="submit" class="button control-button" name="builder" value="'.$action.'" />';
			$output .= '</div>';
			
			if (!empty($value) && is_array($value) && min($value)) {
			
				foreach ($value as $id => $option) {
					
					$output .= '<div class="file-display"><span>'.$option.'</span><input type="submit" class="button-secondary remove-data" data-field="'.$field['label'].'" data-remove="'.$id.'" name="'.$name.'_remove['.$id.']" value="'.__('Delete', 'admin translation').'" /></div>';
				}
			}
			
			return $output;
		}
	}
?>