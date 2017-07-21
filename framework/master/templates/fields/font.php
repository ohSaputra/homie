<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Font field options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (font)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// description 		= The description of what this field will do for the user
	//

	class Font_Field {

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

			$class = isset($options['class']) ? $options['class'] : 'regular-text';
			$id = isset($options['id']) ? $options['id'].'-preview' : Field::get_label_name($field['label']).'-preview';
			$name = isset($options['name']) ? $options['name'] : THEME_NAME.'_'.$field['label'];
			$tabindex = isset($options['index']) ? ' tabindex="'.$options['index'].'"' : '';

			$font = '';
			$fonts = get_template_directory().'/files/google-fonts.cache';
			
			$output .= '<select class="'.$class.'" name="'.$name.'" id="'.$id.'"'.$tabindex.'>';
			
			if (file_exists($fonts)) {
				
				$assets = maybe_unserialize(file_get_contents($fonts));
				
				if (is_array($assets) && count($assets) >= 1) {
					
					$output .= '<option value="0">'.____('- System default', 'admin translation').'</option>';
					
					foreach ($assets as $id => $option) {
						
						if ($value == $option['css-name']) { $font = $option; $selected = ' selected="selected"'; } else  { $selected = ''; } 
						
						$output .= '<option value="'.$option['css-name'].'"'.$selected.' data-family="font-family: \''.$option['font-name'].'\', sans-serif;">'.$option['font-name'].'</option>';
					}
				}
				else {
					
					$output .= '<option value="0">'.____('- System default', 'admin translation').'</option>';
				}
			}
			else {
				
				$output .= '<option value="0">'.____('- System default', 'admin translation').'</option>';
			}
			
			$output .= '</select>';
			$output .= '<div class="google-font-preview"><span>'.__('Sample Text', 'admin translation').'</span></div>';
			
			update_option(THEME_NAME.'_css_font_file', empty($value) ? '' : $font);
			
			return $output;
		}
	}
?>