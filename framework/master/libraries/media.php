<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Generates form fields from custom theme options

	class Media {

		public function __construct() {

			add_filter('wp_get_attachment_url', array($this, 'ssl'), 1, 2);
			add_action('image_resize_dimensions', array($this, 'resize'), 1, 6);
		}
		/**
		 * Correcting a SSL bug in get attachment URL
		 *
		 * @param $url 				- attachment URL
		 * @param $id 				- attachment ID
		 *
		 * @return string
		 */

		public function ssl($url, $id) {

			$url = is_ssl() ? str_replace('http://', 'https://', $url) : $url;

			return $url;
		}

		/**
		 * Resizes images dynamically using wordpress built in image handling functions (scales up or down)
		 *
		 * @param $default 			- whether to preempt output of the resize dimensions
		 * @param $orig_w 			- original width dimension
		 * @param $orig_h 			- original height dimension
		 * @param $new_w 			- new width dimension
		 * @param $new_h 			- new height dimension
		 * @param $crop 			- true, false or an array with crop positions
		 *
		 * @return array
		 */

		public function resize($default, $orig_w, $orig_h, $new_w, $new_h, $crop = false) {

			if ($crop) {
				
				$orientation = $orig_h > $orig_w ? 'portrait' : 'landscape';
				$orientation = $orig_h === $orig_w ? 'square' : $orientation;

				$ratio = $orig_w / $orig_h;

				if (! $new_w) { $new_w = intval($new_h * $ratio); }
				if (! $new_h) { $new_h = intval($new_w / $ratio); }

	        	$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

		        $crop_w = round($new_w / $size_ratio);
		        $crop_h = round($new_h / $size_ratio);

		        if (is_array($crop)) {

		        	switch ($crop[0]) {

						case 'left':

							$s_x = 0;

						break;
						case 'center':

							$s_x = floor(($orig_w - $crop_w) / 2);

						break;
						case 'right':

							$s_x = floor($orig_w - $crop_w);

						break;
						default:

							$s_x = 0;

						break;
					}

					switch ($crop[1]) {

						case 'top':

							$s_y = 0;

						break;
						case 'center':

							$s_y = floor(($orig_h - $crop_h) / 2);

						break;
						case 'bottom':

							$s_y = floor($orig_h - $crop_h);

						break;
						default:

							$s_y = 0;

						break;
					}
		        }
		        else {

		        	$s_x = floor(($orig_w - $crop_w) / 2);
		        	$s_y = floor(($orig_h - $crop_h) / 2);
		        }

			}
			else {

				$crop_w = $orig_w;
	        	$crop_h = $orig_h;

	        	$s_x = 0;
	        	$s_y = 0;

	        	if ($orig_w >= $new_w && $orig_h >= $new_h) {

	        		list($new_w, $new_h) = wp_constrain_dimensions($orig_w, $orig_h, $new_w, $new_h);
	        	}
	        	else {

	        		$ratio = $new_w / $orig_w;

		            $w = intval($orig_w  * $ratio);
		            $h = intval($orig_h * $ratio);

		            list($new_w, $new_h) = array($w, $h);
	        	}
			}

			if ($new_w === $orig_w && $new_h === $orig_h) { return false; }

			return array(0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h);
		}

	}

	new Media();

?>