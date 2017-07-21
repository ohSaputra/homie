<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Gmap field options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (gmap)
	// value			= The default value for this field (an array of ['latitude'], ['longitude'] or ['zoom'])
	// description 		= The description of what this field will do for the user
	//
	
	class Gmap_Field {

		/**
		 * Returns a google map field
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
			
			$width = '';
			$height = '';

			$default_latitude = isset($value['latitude']) ? $value['latitude'] : 47.872144;
			$default_longitude = isset($value['longitude']) ? $value['longitude'] : 12.832031;
			$default_zoom = isset($value['zoom']) ? $value['zoom'] : 5;
							
			$output .= '<div class="gmap-form" id="'.$id.'">';
			
			$output .= '<div class="gmap-field">';
			$output .= '<label>'.__('Address', 'admin translation').'</label>';
			$output .= '<input type="text" class="'.$class.' half-text" name="'.$name.'[address]" id="'.$id.'-address" size="16"'.$tabindex.' value="" /><input type="button" class="button control-button" id="'.$id.'-button" value="'.__('Find address', 'admin translation').'"/>';
			$output .= '</div>';
			
			$output .= '<div class="gmap-location"><div class="geomap" id="'.$id.'-location" data-width="'.$width.'" data-height="'.$height.'"></div></div>';
			
			$output .= '<div class="gmap-field">';
			$output .= '<label>'.__('Latitude', 'admin translation').'</label>';
			$output .= '<input type="text" class="'.$class.'" name="'.$name.'[latitude]" id="'.$id.'-latitude" size="26" value="'.$default_latitude.'" />';
			$output .= '</div>';
			
			$output .= '<div class="gmap-field">';
			$output .= '<label>'.__('Longitude', 'admin translation').'</label>';
			$output .= '<input type="text" class="'.$class.'" name="'.$name.'[longitude]" id="'.$id.'-longitude" size="26" value="'.$default_longitude.'" />';
			$output .= '</div>';
			
			$output .= '<div class="gmap-field">';
			$output .= '<label>'.__('Zoomlevel', 'admin translation').'</label>';
			$output .= '<input type="text" class="'.$class.'" name="'.$name.'[zoom]" id="'.$id.'-zoom" size="26" value="'.$default_zoom.'" />';
			$output .= '</div>';
			
			$output .= '</div>';
			
			wp_enqueue_script('js-admin-gmap', THEME_ADMIN_ASSETS.'/js/admin-gmap.min.js', array('jquery'), false, true);
			wp_enqueue_script('js-gmap', 'https://maps.googleapis.com/maps/api/js?key='.GOOGLE_API_KEY.'', array('jquery', 'js-admin-gmap'), false, true);
			
			return $output;
		}
	}
?>