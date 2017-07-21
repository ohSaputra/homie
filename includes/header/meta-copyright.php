<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	

	$id = get_page_id();

	if (is_category() || is_tax()) {
				
		$content = get_term_meta($id, 'meta_copyright', true);
		$content = empty($content) ? get_theme_option('seo_options', 'meta_copyright') : $content;
	}
	else if (is_single() || is_page()) {
		
		$content = get_post_meta($id, 'meta_copyright', true);
		$content = empty($content) ? get_theme_option('seo_options', 'meta_copyright') : $content;
	}
	else {
		
		$content = get_theme_option('seo_options', 'meta_copyright');
	}

	$output = empty($content) ? '' : '<meta name="copyright" content="'.htmlspecialchars(trim($content), ENT_QUOTES).'" />'."\n";
	
	echo $output;
?>
