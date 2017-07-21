<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class verify_email_list {

		/**
		 * Verifies that the input value is an email
		 *
		 * @param $slug 	- string database name
		 * @param $value 	- saved value in database
		 * @param $field 	- array of current field settings
		 * @param $post 	- posted input value
		 * @param $options 	- array with optional values to use for validation ['form']
		 *
		 * @return array
		 */

		public static function validate($slug, $value, $field, $post, $options) {
			
			$error = false;
			$list = convert_string_to_array($post);
			
			if (is_array($list) && count($list) >= 1) {

				foreach ($list as $key => $value) {
					
					if (! is_email($value)) { $error = true; break; }
				}

				if ($error) {

					$result['value'] = $field['type'] == 'text' ? implode(', ', $list) : implode("\n", $list);
					$result['error'] = $field['label'];
					$result['feedback'] = __('The submitted email list contains error, please check that all email addresses in your list are correct.', 'admin translation');
				}
				else {

					$result['value'] = $field['type'] == 'text' ? implode(', ', $list) : implode("\n", $list);
					$result['error'] = '';
					$result['feedback'] = '';
				}
			}
			else {

				if (empty($post)) {

					$result['value'] = $post;
					$result['error'] = '';
					$result['feedback'] = '';
				}
				else {

					$result['value'] = $post;
					$result['error'] = $field['label'];
					$result['feedback'] = $field['type'] == 'text' ? __('The submitted value is not a valid email list. Make sure that you use a comma separated list of emails.', 'admin translation') : __('The submitted value is not a valid email list. Make sure that you type one email on each row.', 'admin translation');
				}
			}

			return $result;
		}
	}
?>