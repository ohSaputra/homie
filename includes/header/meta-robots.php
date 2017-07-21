<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$id = get_page_id();

	if (is_category() || is_tax()) {
		
		$meta = true;
		$robots = get_term_meta($id, 'meta_robots', true);
	}
	else if (is_singular() && !is_attachment()) {
		
		$meta = true;
		$robots = get_post_meta($id, 'meta_robots', true);
	}
	else {
		
		$meta = is_front_page() || is_archive() ? true : false;
	}
	
	if (get_option('blog_public') && $meta != false) {
		
		if (isset($robots)) { $robots = $robots != '1' ? 'index, follow' : 'noindex, nofollow'; } else { $robots = 'index, follow'; }
	}
	else {
		
		$robots = 'noindex, nofollow';
	}

?>
<meta name="robots" content="<?php echo $robots; ?>" />
