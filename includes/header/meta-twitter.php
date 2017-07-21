<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$output = '';

	$id = get_page_id();

	$site = get_bloginfo('name');
	$url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$api = get_theme_option('open_graph_options', 'facebook_id');

	if (is_category() || is_tax()) {
		
		$term = get_term($id);
		$title = get_term_meta($id, 'twitter_title', true);
		$description = get_term_meta($id, 'twitter_description', true);

		$source = get_term_meta($id, 'twitter_media', true);
		$image = !empty($source) && isset($source[0]) && is_array($source[0]) ? site_url().str_replace(site_url(), '', $source[0]['url']) : '';

		$title = empty($title) ? get_page_title() : $title;
		$description = empty($description) ? term_description($id, $term->taxonomy) : $description;
	}
	else if (is_singular()) {
		
		$post = get_post($id);
		$title = get_post_meta($id, 'twitter_title', true);
		$description = get_post_meta($id, 'twitter_description', true);

		$source = get_post_meta($id, 'twitter_media', true);
		$image = !empty($source) && isset($source[0]) && is_array($source[0]) ? site_url().str_replace(site_url(), '', $source[0]['url']) : get_the_post_thumbnail_url($id, 'large');

		$title = empty($title) ? get_page_title() : $title;
		$description = empty($description) ? strip_shortcodes($post->post_content) : $description;
	}
	else {
		
		$title = is_front_page() ? get_theme_option('open_graph_options', 'twitter_title') : get_page_title();
		$description = is_front_page() ? get_theme_option('open_graph_options', 'twitter_description') : get_bloginfo('description');

		$source = get_theme_option('open_graph_options', 'twitter_media');
		$image = !empty($source) && isset($source[0]) && is_array($source[0]) ? site_url().str_replace(site_url(), '', $source[0]['url']) : '';
	}

	$user = get_theme_option('open_graph_options', 'twitter_username');
	$card = 'summary_large_image';

	$output .= '<meta name="twitter:card" content="'.$card.'" />'."\n";
	$output .= '<meta name="twitter:site" content="'.$user.'" />'."\n";
	$output .= '<meta name="twitter:creator" content="'.$user.'" />'."\n";
	$output .= '<meta name="twitter:title" content="'.htmlspecialchars(get_text_excerpt($title, 160)).'" />'."\n";
	$output .= '<meta name="twitter:description" content="'.htmlspecialchars(get_text_excerpt($description, 240)).'" />'."\n";
	$output .= '<meta name="twitter:image" content="'.$image.'" />'."\n";

	echo $output;
?>

