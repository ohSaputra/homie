<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	$id = get_page_id();
		
	if (is_category() || is_tax()) {
				
		$term = get_term($id);
		$content = get_term_meta($id, 'meta_description', true);
		$content = empty($content) ? term_description($id, $term->taxonomy) : $content;
	}
	else if (is_singular()) {
		
		$content = get_post_meta($id, 'meta_description', true);
		$content = empty($content) ? strip_shortcodes($post->post_content) : $content;
	}
	else if (is_author()) {

		$author = $post->post_author;

		$name = trim(get_the_author_meta('user_firstname')).' '.trim(get_the_author_meta('user_lastname'));
		$name = empty($name) ? trim(get_the_author_meta('nickname')) : trim($name);
		$name = empty($name) ? __('Anonymous', 'theme translation') : $name;

		$content = get_the_author_meta('description', $author);
		$content = empty($content) ? sprintf(__('These are all our collected articles written by %s. Have a look and enjoy your reading.', 'theme translation'), $name) : $name.' - '.$content;
	}
	else {
		
		$content = is_front_page() ? get_theme_option('seo_options', 'meta_description') : get_bloginfo('description');
	}

?>
<meta name="description" content="<?php echo htmlspecialchars(get_text_excerpt($content, 240)); ?>" />
