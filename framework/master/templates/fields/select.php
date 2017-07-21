<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Select box options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (select)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// default			= The label name to override 'System default'
	// options			= The options available in this field (an array containing text keys, or a function returning an array)
	// description 		= The description of what this field will do for the user
	//

	class Select_Field {

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

			$options = $field['options'];
			
			$output .= '<select class="'.$class.'" name="'.$name.'" id="'.$id.'"'.$tabindex.'>';
			
			if (!empty($options) && is_array($options)) {
				
				if (is_array($options[key($options)]) && array_key_exists('optgroup', $options[key($options)])) {
					
					if (isset($field['default']) && $field['default'] == false) { $counter = 0; } else { if (isset($field['default']) && !empty($field['default'])) { $output .= '<option value="0">'.$field['default'].'</option>'; $counter = 1; } else { $output .= '<option value="0">'.__('- System default', 'admin translation').'</option>'; $counter = 1; } }
					
					foreach ($options as $id => $option) {
						
						$output .= '<optgroup label="'.$option['optgroup'].'">';
						
						foreach ($option['options'] as $id => $index) {
							
							if (is_array($index)) {
								
								$content = (isset($index['id'])) ? $index['id']: $index[1];
								$index = (isset($index['title'])) ? $index['title']: $index[0];
							} 
							else { 
							
								$content = self::slug($index);
							}
							
							if ($value == $content) { $selected = ' selected="selected"'; } else  { $selected = ''; } 
							
							$output .= '<option value="'.$content.'"'.$selected.'>'.$index.'</option>';
						}
						
						$output .= '</optgroup>';
					}
				}
				else {
					
					if (isset($field['default']) && $field['default'] == false) { $counter = 0; } else { if (isset($field['default']) && !empty($field['default'])) { $output .= '<option value="0">'.$field['default'].'</option>'; $counter = 1; } else { $output .= '<option value="0">'.__('- System default', 'admin translation').'</option>'; $counter = 1; } }
					
					foreach ($options as $id => $option) {
						
						if (is_array($option)) {
							
							$content = (isset($option['id'])) ? $option['id']: $option[1];
							$option = (isset($option['title'])) ? $option['title']: $option[0];
						} 
						else { 
						
							$content = $id + $counter;
						}
						
						if ($value == $content) { $selected = ' selected="selected"'; } else  { $selected = ''; } 
						
						$output .= '<option value="'.$content.'"'.$selected.'>'.$option.'</option>';
					}	
				}
			}
			else {
				
				$output .= '<option value="0">'.__('- System default', 'admin translation').'</option>';
			}
			
			$output .= '</select>';

			return $output;
		}
				
		/**
		 * Replaces spaces between words with hyphens
		 *
		 * @param $string 		- slug string
		 * @param $divider		- type of character to use in between words
		 *
		 * @return string
		 */

		public static function slug($string, $divider = '-') {
					
			$string = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
			$slug = preg_replace('/[^A-Za-z0-9-]+/', $divider, trim(strtolower($string)));
			$slug = rtrim($slug, $divider);
			
			return $slug;
		}
	}
?>