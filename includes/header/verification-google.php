<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$output = '';
	
	$google = get_theme_option('seo_options', 'google_verification_code');
	$output .= empty($google) ? '' : '<meta name="google-site-verification" content="'.$google.'" />'."\n";

	echo $output;
?>