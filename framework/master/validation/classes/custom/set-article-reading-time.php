<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class set_article_reading_time {

		/**
		 * Flushing and removes permalink settings rules and recreates them
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
			
			$words = str_word_count(strip_tags($_POST['content']));
			$minutes = floor($words / 160);
			$seconds = floor($words % 160 / (120 / 60));

			if (1 <= $minutes) {
				
				$time = $minutes.' '.__('min.', 'theme translation');
			}
			else {
				
				$time = $seconds.' '.__('sec.', 'theme translation');
			}

			$output = array('words' => $words, 'time' => $time);

			$result['value'] = $output;
			$result['error'] = '';

			return $result;
		}
	}
?>