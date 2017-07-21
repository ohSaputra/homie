<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$source_192 = get_theme_option('layout_options', 'android_touch_192_icon');
	$source_128 = get_theme_option('layout_options', 'android_touch_128_icon');

	echo !empty($source_192) && isset($source_192[0]) && is_array($source_192[0]) ? '<link rel="icon" sizes="192x192" href="'.site_url().$source_192[0]['url'].'" />'."\n" : '';
	echo !empty($source_128) && isset($source_128[0]) && is_array($source_128[0]) ? '<link rel="icon" href="'.site_url().$source_128[0]['url'].'" />'."\n" : '';
	
?>
