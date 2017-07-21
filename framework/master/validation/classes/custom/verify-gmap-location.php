<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions\Validate;

	// Validate a posted form and returns the result

	class verify_gmap_location {

		/**
		 * Verifies a google map location and saves it to the database
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
			
			$latitude = $_POST[THEME_NAME.'_'.$field['label'].'_latitude'];
			$longitude = $_POST[THEME_NAME.'_'.$field['label'].'_longitude'];
			$zoom = $_POST[THEME_NAME.'_'.$field['label'].'_zoom'];
			
			$result['value'] = array('0' => array('latitude'=> $latitude, 'longitude'=> $longitude, 'zoom'=> $zoom));
			$result['error'] = '';

			return $result;
		}
	}
?>