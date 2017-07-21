<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$content = get_theme_option('open_graph_options', 'google_url');

	$output = empty($content) ? '' : '<link rel="publisher" href="'.trim($content).'" />'."\n";
	
	echo $output;
?>
