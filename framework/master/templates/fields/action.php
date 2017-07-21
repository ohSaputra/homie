<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Action button options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (action)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// feedback			= The feedback to be displayed after a trigger action have been executed
	// description 		= The description of what this field will do for the user
	//

	class Action_Field {

		/**
		 * Returns a button, which triggers a call function to be run on submit
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
			$label = isset($field['action']) ? $field['action'] : $field['name'];
			
			if ($field['type'] === 'action export') {

				$option = str_replace('_', '-', $field['label']);
				$entry = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
				
				$output .= '<input type="submit" class="button-secondary action-button export-button" name="action" data-feedback="'.$field['feedback'].'" data-url="'.wp_nonce_url(admin_url('admin.php?page='.$entry.'&amp;action='.$option), 'generate-export').'" value="'.$label.'" />';
				$output .= '<input type="hidden" class="'.$class.'" name="'.$name.'" id="'.$id.'" size="36"'.$tabindex.' value="" />';

			}
			else {

				$output .= '<input type="submit" class="button-secondary action-button" name="action" data-feedback="'.$field['feedback'].'" value="'.$label.'" />';
				$output .= '<input type="hidden" class="'.$class.'" name="'.$name.'" id="'.$id.'" size="36"'.$tabindex.' value="" />';
			}
			
			return $output;
		}
	}
?>