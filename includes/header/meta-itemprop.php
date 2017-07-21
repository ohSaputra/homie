<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	$output = '';

	$id = get_page_id();
	
	if (is_category() || is_tax()) {
		
		$term = get_term($id);
		$title = get_term_meta($id, 'facebook_title', true);
		$description = get_term_meta($id, 'facebook_description', true);

		$source = get_term_meta($id, 'facebook_media', true);
		$image = !empty($source) && isset($source[0]) && is_array($source[0]) ? site_url().str_replace(site_url(), '', $source[0]['url']) : '';

		$title = empty($title) ? get_page_title() : $title;
		$description = empty($description) ? term_description($id, $term->taxonomy) : $description;
	}
	else if (is_singular()) {
		
		$post = get_post($id);
		$title = get_post_meta($id, 'facebook_title', true);
		$description = get_post_meta($id, 'facebook_description', true);

		$source = get_post_meta($id, 'facebook_media', true);
		$image = !empty($source) && isset($source[0]) && is_array($source[0]) ? site_url().str_replace(site_url(), '', $source[0]['url']) : get_the_post_thumbnail_url($id, 'large');

		$title = empty($title) ? get_page_title() : $title;
		$description = empty($description) ? strip_shortcodes($post->post_content) : $description;
	}
	else {
		
		$title = is_front_page() ? get_theme_option('open_graph_options', 'facebook_title') : get_page_title();
		$description = is_front_page() ? get_theme_option('open_graph_options', 'facebook_description') : get_bloginfo('description');

		$source = get_theme_option('open_graph_options', 'facebook_media');
		$image = !empty($source) && isset($source[0]) && is_array($source[0]) ? site_url().str_replace(site_url(), '', $source[0]['url']) : '';
	}

	$output .= '<meta itemprop="name" content="'.htmlspecialchars(get_text_excerpt($title, 160)).'"/>'."\n";
	$output .= '<meta itemprop="description" content="'.htmlspecialchars(get_text_excerpt($description, 240)).'"/>'."\n";
	$output .= '<meta itemprop="image" content="'.$image.'"/>'."\n";

	echo $output;
?>
