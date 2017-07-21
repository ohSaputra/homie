<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$source = get_theme_option('layout_options', 'windows_144_tile');
	$color = get_theme_option('layout_options', 'windows_tile_color');

	echo !empty($source) && isset($source[0]) && is_array($source[0]) ? '<meta name="msapplication-TileImage" content="'.site_url().$source[0]['url'].'" />'."\n" : '';
	echo !empty($color) ? '<meta name="msapplication-TileColor" content="'.$color.'">'."\n" : '';

?>
