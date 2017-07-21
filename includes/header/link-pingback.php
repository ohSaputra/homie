<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$active = get_option('enable_xmlrpc');
	$output = empty($active) ? '' : '<link rel="pingback" href="'.get_bloginfo('pingback_url').'" />'."\n";
	
	echo $output;
?>