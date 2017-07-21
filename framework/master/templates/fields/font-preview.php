<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Font preview options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (font preview)
	// minvalue			= The minimum value for range field input (integer)
	// maxvalue			= The maximum value for range field input (integer)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// unit 			= The unit value displayed (text string like px, mm, or em)
	// description 		= The description of what this field will do for the user
	//
	
	class Font_Preview_Field {

		/**
		 * Returns a font preview field
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

			$id = isset($options['id']) ? $options['id'] : Field::get_label_name($field['label']);
			$name = isset($options['name']) ? $options['name'] : THEME_NAME.'_'.$field['label'];
			$tabindex = isset($options['index']) ? ' tabindex="'.$options['index'].'"' : '';
						
			$step = 1;
			$progress = 'true';
			
			$min = isset($field['minvalue']) ? $field['minvalue'] : 12;
			$max = isset($field['maxvalue']) ? $field['maxvalue'] : 12;
			$unit = isset($field['unit']) ? $field['unit'] : __('XX', 'admin translation');
			
			$value = empty($value) ? $field['value'] : $value;
			
			$output .= $field['type'] == 'scope preview' ? '<div class="google-font-preview google-font-preview-size" style="font-size: '.$value.'px"><span>'.__('Sample Text', 'admin translation').'</span></div>' : '';
			
			$output .= '<div class="range-value"><span class="range-min-value">'.strtoupper($min).'</span><span class="range-current-value">0</span><span class="range-max-value">'.strtoupper($max).'</span></div>';
			$output .= '<input type="range" class="range" name="'.$name.'" id="'.$id.'" min="'.$min.'" max="'.$max.'" step="'.$step.'" data-progress="'.$progress.'" data-bytes="false" data-unit="'.$unit.'"'.$tabindex.' value="'.$value.'" />';
		
			return $output;
		}
	}
?>