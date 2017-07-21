<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Text area options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (textarea)
	// maximum			= The maximum amount of characters or words supported (adds a text counter)
	// rows				= The number of rows to be used (height of field)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// description 		= The description of what this field will do for the user
	//

	class Textarea_Field {

		/**
		 * Returns a textarea box field
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

			$rows = (isset($field['rows']) && !empty($field['rows'])) ? $field['rows'] : '6';
			
			if (isset($field['maximum']) && ($field['maximum'] != '')) { $class .= ' text-counter'; $meta = ' data-max="'.$field['maximum'].'"'; } else if (isset($field['wordcount']) && ($field['wordcount'] != '')) { $class .= ' word-counter'; $meta = ' data-max="'.$field['wordcount'].'"'; } else if (isset($field['keycount']) && ($field['keycount'] != '')) { $class .= ' key-counter'; $meta = ' data-max="'.$field['keycount'].'"'; } else { $class .= ''; $meta = ''; }
			
			$output .= '<textarea class="'.$class.'" name="'.$name.'" id="'.$id.'" rows="'.$rows.'" cols="40"'.$tabindex.''.$meta.'>'.stripslashes($value).'</textarea>';
			
			return $output;
		}
	}
?>