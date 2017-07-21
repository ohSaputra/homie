<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Radio box options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (radio)
	// rendering		= The presentation view (block or line)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// options			= The options available in this field (an array containing text keys, or a function returning an array)
	// description 		= The description of what this field will do for the user
	//

	class Radio_Field {

		/**
		 * Returns a radio box field
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

			$tag = isset($options['id']) ? $options['id'] : Field::get_label_name($field['label']);
			$name = isset($options['name']) ? $options['name'] : THEME_NAME.'_'.$field['label'];
			$tabindex = isset($options['index']) ? ' tabindex="'.$options['index'].'"' : '';

			if (!empty($field['options']) && is_array($field['options'])) {
				
				if (isset($field['rendering']) && ($field['rendering'] == 'block')) { $class = ' block-label'; } else { $class = ''; }
				
				$output .= '<div class="radio-group"'.$tabindex.'>';
				
				foreach ($field['options'] as $id => $option) {
					
					if (is_array($option)) { $content = $option[1]; $option = $option[0]; } else { $content = $id + 1; }
					if ($value == $content) { $checked = ' checked="checked"'; } else  { $checked = ''; } 
					
					$output .= '<label class="radio-label'.$class.'" for="'.$tag.'-'.$id.'"><input type="radio" class="radio" name="'.$name.'" id="'.$tag.'-'.$id.'" value="'.$content.'"'.$checked.'/> '.$option.'</label>';
				}
				
				$output .= '</div>';
			}
			else {

				$output .= '<p class="note">'.sprintf(__('Your %s are empty', 'admin translation'), strtolower($field['name'])).'</p>';
			}
						
			return $output;
		}
	}
?>