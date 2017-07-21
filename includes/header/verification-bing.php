<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$output = '';
	
	$bing = get_theme_option('seo_options', 'bing_verification_code');
	$output .= empty($bing) ? '' : '<meta name="msvalidate.01" content="'.$bing.'" />'."\n";
	
	echo $output;	
?>