<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$id = get_page_id();

	if (is_category() || is_tax()) {
				
		$content = get_term_meta($id, 'meta_author', true);
	}
	else if (is_single() || is_page()) {
		
		$content = get_post_meta($id, 'meta_author', true);
	}
	else {
		
		$content = get_theme_option('seo_options', 'meta_author');
	}
	
	$output = empty($content) ? '' : '<meta name="author" content="'.htmlspecialchars(trim($content), ENT_QUOTES).'" />'."\n";
	
	echo $output;
?>
