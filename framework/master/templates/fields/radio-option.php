<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Radio option list options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (radio option)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// images			= The images to be displayed for each option (an array containing image keys)
	// options			= The options available in this field (an array containing text keys, or a function returning an array)
	// description 		= The description of what this field will do for the user
	//

	class Radio_Option_Field {

		/**
		 * Returns a radio option field with a graphical display
		 *
		 * @param $slug 	- string database name
		 * @param $field 	- array with current field settings
		 * @param $value 	- string or array of current field value
		 * @param $columns 	- integer of how many columns the grid should be in (1, 2, 3 or 4)
		 * @param $images 	- string name to an image that will be used as a selector
		 * @param $options 	- array with optional values ['class'], ['name'], ['id'], ['index']
		 *
		 * @return string $html
		 */

		public static function html($slug, $field, $value, $options = array()) {
				
			$output = '';

			$id = isset($options['id']) ? $options['id'] : Field::get_label_name($field['label']);
			$name = isset($options['name']) ? $options['name'] : THEME_NAME.'_'.$field['label'];
			$tabindex = isset($options['index']) ? ' tabindex="'.$options['index'].'"' : '';
			$columns = isset($field['columns']) ? intval($field['columns']) : 3;
			
			$columns = $columns === 2 || $columns === 4 ? $columns : 3;
			$width = 130;
			$height = 90;

			if (!empty($field['options']) && is_array($field['options'])) {
					
				foreach ($field['options'] as $counter => $option) {
					
					$modulo = $counter % $columns;
				
					if ($modulo == 0) {
													
						$output .= '<div class="radio-graphic-group radio-graphic-'.$columns.'"'.$tabindex.'>';
					}
					
					$output .= '<label class="radio-graphic">';
					
					if (is_array($option)) { $content = $option[1]; $option = $option[0]; } else { $content = $counter + 1; }
					if ($value == $content) { $checked = ' checked="checked"'; } else  { $checked = ''; }
					
					if (isset($field['images'][$counter]) && !empty($field['images'][$counter])) {
						
						$src = THEME_ADMIN_ASSETS.'/img/'.$field['images'][$counter];
						$output .= '<div class="graphic"><img src="'.$src.'" width="'.$width.'" height="'.$height.'" alt="'.$option.'" /></div>';
					}
					else {
						
						$src = THEME_ADMIN_ASSETS.'/img/radio-graphic-default.png';
						$output .= '<div class="graphic"><img src="'.$src.'" width="'.$width.'" height="'.$height.'" alt="'.$option.'" /></div>';
					}
					
					$output .= '<input type="radio" class="radio" name="'.$name.'" id="'.$id.'-'.$counter.'" value="'.$content.'"'.$checked.'/>';
					$output .= '<span>'.$option.'</span>';
					
					$output .= '</label>';
					
					if ($modulo == ($columns - 1) || $counter == count($field['options']) - 1) {
						
						$output .= '</div>';
					}
				}
			}
			
			return $output;
		}
	}
?>