<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Color options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (color picker)
	// value			= The default value for this field (a hex color number)
	// description 		= The description of what this field will do for the user
	//

	class Color_Field {

		/**
		 * Returns a select box field
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

			$default = isset($field['value']) ? $field['value'] : '';
			
			$output .= '<input type="text" class="'.$class.' color-picker-field" name="'.$name.'" id="'.$id.'-field" size="36"'.$tabindex.' value="#'.str_replace('#', '', $value).'" />';
			$output .= '<a href="javascript:void(0);" class="color-picker color-picker-example" id="'.$id.'-example" data-field="'.$id.'"></a>';
			$output .= '<input type="button" class="color-picker button" data-field="'.$id.'" value="'.__('Select a Color', 'admin translation').'">';
			$output .= '<span class="color-picker-default" id="'.$id.'-default">'.__('Set default color', 'admin translation').': <a class="link" title="#'.$default.'">#'.$default.'</a></span>';
			$output .= '<div class="farbtastic color-picker-box" id="color-picker-box"></div>';
			
			return $output;
		}
	}
?>