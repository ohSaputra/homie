<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$source = get_theme_option('layout_options', 'favicon');

	echo !empty($source) && isset($source[0]) && is_array($source[0]) ? '<link rel="shortcut icon" href="'.site_url().$source[0]['url'].'" />'."\n" : '';

?>
