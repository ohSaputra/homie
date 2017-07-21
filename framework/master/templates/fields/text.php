<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;

	// Text options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// maximum			= The maximum amount of characters or words supported (adds a text counter)
	// type				= The type name of this field (text)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// description 		= The description of what this field will do for the user
	//
	
	class Text_Field {

		/**
		 * Returns a text input field
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

			if (isset($field['maximum']) && ($field['maximum'] != '')) { $class .= ' text-counter'; $meta = ' data-max="'.$field['maximum'].'"'; } else if (isset($field['wordcount']) && ($field['wordcount'] != '')) { $class .= ' word-counter'; $meta = ' data-max="'.$field['wordcount'].'"'; } else if (isset($field['keycount']) && ($field['keycount'] != '')) { $class .= ' key-counter'; $meta = ' data-max="'.$field['keycount'].'"'; } else { $class .= ''; $meta = ''; }
			
			$output .= '<input type="text" class="'.$class.'" name="'.$name.'" id="'.$id.'" size="36"'.$tabindex.''.$meta.' value="'.stripslashes($value).'" />';
			
			return $output;
		}
	}
?>