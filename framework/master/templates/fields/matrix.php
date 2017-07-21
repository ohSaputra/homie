<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Matrix options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (matrix)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// columns 			= The column names to be used in the matrix (array with 2 text keys)
	// description 		= The description of what this field will do for the user
	//
	
	class Matrix_Field {

		/**
		 * Returns a matrix field element
		 *
		 * @param $slug 	- string database name
		 * @param $field 	- array with current field settings
		 * @param $value 	- string or array of current field value
		 * @param $columns 	- integer to set how many columns to use [1, 2 or 3]
		 * @param $labels 	- option to add field labels above each column, must be an array and match amount of columns
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
			$labels = isset($field['labels']) && is_array($field['labels']) ? true : false;
						
			$columns = $field['columns'];
			
			$output .= "\n\n";		
			$output .= '<table class="matrix-table matrix-'.$columns.'-columns '.$name.'" id="'.$id.'" data-columns="'.$columns.'" data-labels="'.$labels.'">'."\n";
			
			if (isset($field['labels']) && is_array($field['labels']) && count($field['labels']) >= 1) {

				$output .= '<tr class="matrix-label" valign="top">'."\n";
			
				for($i = 0; $i < $columns; ++$i) {
					
					$output .= '<td>'.(isset($field['labels'][$i]) ? $field['labels'][$i] : '&nbsp;').'</td>'."\n";
				}
				
				$output .= '</tr>'."\n";
			}
						
			if (!empty($value) && is_array($value)) {

				switch ($columns) {

					case 1:

						foreach ($value as $id => $option) {
							
							$output .= '<tr class="matrix-row" valign="top">'."\n";
							$output .= '<td><input type="text" class="'.$class.' auto" name="'.$name.'['.$id.'][0]" size="12" value="'.(isset($option[0]) ? $option[0] : '').'" /></td>'."\n";
							$output .= '</tr>'."\n";
						}

					break;
					case 3:

						foreach ($value as $id => $option) {
							
							$output .= '<tr class="matrix-row" valign="top">'."\n";
							$output .= '<td><input type="text" class="'.$class.' auto" name="'.$name.'['.$id.'][0]" size="4" value="'.(isset($option[0]) ? $option[0] : '').'" /></td>'."\n";
							$output .= '<td><input type="text" class="'.$class.' auto" name="'.$name.'['.$id.'][1]" size="4" value="'.(isset($option[1]) ? $option[1] : '').'" /></td>'."\n";
							$output .= '<td><input type="text" class="'.$class.' auto" name="'.$name.'['.$id.'][2]" size="4" value="'.(isset($option[2]) ? $option[2] : '').'" /></td>'."\n";
							$output .= '</tr>'."\n";
						}

					break;
					default:

						foreach ($value as $id => $option) {
							
							$output .= '<tr class="matrix-row" valign="top">'."\n";
							$output .= '<td><input type="text" class="'.$class.' auto" name="'.$name.'['.$id.'][0]" size="8" value="'.(isset($option[0]) ? $option[0] : '').'" /></td>'."\n";
							$output .= '<td><input type="text" class="'.$class.' auto" name="'.$name.'['.$id.'][1]" size="8" value="'.(isset($option[1]) ? $option[1] : '').'" /></td>'."\n";
							$output .= '</tr>'."\n";
						}

					break;
				}
				
			}
			else {
				
				$output .= '<tr class="matrix-row" valign="top">'."\n";
				
				for($i = 0; $i < $columns; ++$i) {
				
					$output .= '<td><input type="text" class="'.$class.' auto" name="'.$name.'[0]['.$i.']" size="8" value="" /></td>'."\n";
				}
				
				$output .= '</tr>'."\n";
			}
			
			$output .= '<tr class="matrix-buttons" valign="top">'."\n";
			$output .= '<td colspan="'.$columns.'"><a href="javascript:void(0);" class="button remove-matrix" data-table="'.$name.'">'.__('Remove', 'admin translation').'</a><a href="javascript:void(0);" class="button add-matrix" data-table="'.$name.'">'.__('Add row', 'admin translation').'</a></td>'."\n";
			$output .= '</tr>'."\n";
			$output .= '</table>'."\n\n";

			$output .= '';
			
			return $output;
		}
	}
?>