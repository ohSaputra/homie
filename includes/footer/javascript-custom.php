<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$output = '';
	
	$content = get_theme_option('seo_options', 'alternative_javascript');
	
	if (!empty($content)) {
			
		$output .= htmlspecialchars_decode(trim($content), ENT_QUOTES)."\n";
	}
	
	echo $output;
?>