<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Select list options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// rows				= The number of rows to be used (height of field)
	// type				= The type name of this field (select list)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// options			= The options available in this field (an array containing text keys, or a function returning an array)
	// description 		= The description of what this field will do for the user
	//

	class Select_List_Field {

		/**
		 * Returns a multiple select box picker
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

			$class = isset($options['class']) ? $options['class'] : 'widefat';
			$id = isset($options['id']) ? $options['id'] : Field::get_label_name($field['label']);
			$name = isset($options['name']) ? $options['name'] : THEME_NAME.'_'.$field['label'];
			$tabindex = isset($options['index']) ? ' tabindex="'.$options['index'].'"' : '';

			$rows = (isset($field['rows']) && !empty($field['rows'])) ? $field['rows'] : '6';
			
			$selected = '';
			$mimetype = '';
			$options = $field['options'];
			
			if (is_array($options)) { ksort($options); }
			if (is_array($value)) { ksort($value); }
			
			$output .= '<div class="enhance-select"'.$tabindex.'>';
			
			$output .= '<p class="conceal">';
			$output .= '<select class="'.$class.' multiple" name="'.$name.'[]" id="'.$id.'" size="8" multiple="multiple">';
			
			if (!empty($options) && is_array($options)) {
				
				if (is_array($options[key($options)]) && array_key_exists('optgroup', $options[key($options)])) {
					
					foreach ($options as $key => $group) {
															
						if ($key == 0) {
							
							$output .= '<optgroup label="'.$field['name'].'">';
							$output .= '<option value="0">'.____('- System default', 'admin translation').'</option>';
							$output .= '</optgroup>';
						}
						
						$output .= '<optgroup label="'.$group['group'].'">';
						
						foreach ($group['options'] as $key => $option) {
							
							if (is_array($value)) { if (in_array($option, $value)) { $selected = ' selected="selected"'; } else  { $selected = ''; } } else { if ($value == $option) { $selected = ' selected="selected"'; } else  { $selected = ''; } }					
						
							$output .= '<option value="'.$option.'" title="'.htmlspecialchars($option).'"'.$selected.'>'.$option.'</option>';
						}
						
						$output .= '</optgroup>';
					}
				}
				else {
					
					foreach ($options as $key => $option) {
						
						if (is_array($option) && isset($option['mimetype']) && !empty($option['mimetype']) && $mimetype != $option['mimetype']) {
							
							if ($key >= 1) { $output .= '</optgroup>'; }
							
							$mimetype = $option['mimetype'];
							$output .= '<optgroup label="'.strtoupper($option['mimetype']).'">';
						}
						
						if (is_array($option)) { $content = (isset($option['id'])) ? $option['id'] : $option[1]; $name = (isset($option['title'])) ? $option['title'] : $option[0]; } else { $content = $key + 1; $name = $option; }
						if (is_array($value)) { if (in_array($content, $value)) { $selected = ' selected="selected"'; } else  { $selected = ''; } } else { if ($value == $content) { $selected = ' selected="selected"'; } else  { $selected = ''; } }					
						
						$title = (is_array($option) && isset($option['mimetype'])) ? $option['mimetype'].' '.__('document', 'admin translation') : $name.' ';
						
						$output .= '<option value="'.$content.'" title="'.htmlspecialchars($title).'"'. $selected .'>&nbsp;'.$name.'</option>';
						
						if (is_array($option) && isset($option['mimetype']) && !empty($option['mimetype']) && $key + 1 == count($options)) {
							
							$output .= '</optgroup>';
						}
					}
				}
			}
			else {
				
				$output .= '<option value="0">'.____('- System default', 'admin translation').'</option>';
			}
			
			$output .= '</select>';
			$output .= '</p>';
			
			$output .= '<p class="idle">';
			$output .= '<select class="widefat multiple enhance-left" id="'.$id.'-enhance-left" size="'.$rows.'" multiple="multiple"></select>';
			$output .= '</p>';
			
			$output .= '<p class="tools">';
			$output .= '<a href="javascript:void(0);" class="button-submit button-secondary select-left" data-id="'.$id.'"><span>'.__('Add', 'admin translation').'</span></a>';
			$output .= '<a href="javascript:void(0);" class="button-submit button-secondary select-right" data-id="'.$id.'"><span>'.__('Remove', 'admin translation').'</span></a>';
			$output .= '</p>';
			
			$output .= '<p class="used">';
			$output .= '<select class="widefat multiple enhance-right" id="'.$id.'-enhance-right" size="'.$rows.'" multiple="multiple"></select>';
			$output .= '</p>';
			
			$output .= '</div>';
			
			return $output;
		}
	}
?>