<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	$id = get_page_id();
	
	if (is_category() || is_tax()) {
				
		$content = get_term_meta($id, 'meta_keywords', true);
	}
	else if (is_single() || is_page()) {
		
		$content = get_post_meta($id, 'meta_keywords', true);
	}
	else {
		
		$content = is_front_page() ? get_theme_option('seo_options', 'meta_keywords') : '';
	}
		
	$output = empty($content) ? '' : '<meta name="keywords" content="'.htmlspecialchars(trim($content), ENT_QUOTES).'" />'."\n";
	
	echo $output;
?>
