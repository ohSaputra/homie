<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$source_180 = get_theme_option('layout_options', 'apple_touch_180_icon');
	$source_152 = get_theme_option('layout_options', 'apple_touch_152_icon');
	$source_120= get_theme_option('layout_options', 'apple_touch_120_icon');
	$source_76 = get_theme_option('layout_options', 'apple_touch_76_icon');
	$source_48 = get_theme_option('layout_options', 'apple_touch_48_icon');
	
	echo !empty($source_180) && isset($source_180[0]) && is_array($source_180[0]) ? '<link rel="apple-touch-icon" sizes="180x180" href="'.site_url().$source_180[0]['url'].'" />'."\n" : '';
	echo !empty($source_152) && isset($source_152[0]) && is_array($source_152[0]) ? '<link rel="apple-touch-icon" sizes="152x152" href="'.site_url().$source_152[0]['url'].'" />'."\n" : '';
	echo !empty($source_120) && isset($source_120[0]) && is_array($source_120[0]) ? '<link rel="apple-touch-icon" sizes="120x120" href="'.site_url().$source_120[0]['url'].'" />'."\n" : '';
	echo !empty($source_76) && isset($source_76[0]) && is_array($source_76[0]) ? '<link rel="apple-touch-icon" sizes="76x76" href="'.site_url().$source_76[0]['url'].'" />'."\n" : '';
	echo !empty($source_48) && isset($source_48[0]) && is_array($source_48[0]) ? '<link rel="apple-touch-icon" href="'.site_url().$source_48[0]['url'].'" />'."\n" : '';

?>
