<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$output = '';
	
	$alexa = get_theme_option('seo_options', 'alexa_verification_code');
	$output .= empty($alexa) ? '' : '<meta name="alexaVerifyID" content="'.$alexa.'" />'."\n";
	
	echo $output;	
?>