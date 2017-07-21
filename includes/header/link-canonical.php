<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$id = get_page_id();

	if (is_search()) {

		$href = get_search_link();
	}
	else if (is_front_page()) {

		$href = home_url('/');
	}
	else if (is_category() || is_tax() || is_tag()) {

		$canonical = get_term_meta($id, 'canonical_url', true);

		$href = empty($canonical) ? '' : $canonical;
	}
	else if (is_single() || is_page()) {

		$canonical = get_post_meta($id, 'canonical_url', true);

		$href = empty($canonical) ? '' : $canonical;
	}
	else if (is_author()) {

		$href = get_author_posts_url(get_query_var('author'), get_query_var('author_name'));
	}
	else {

		$href = '';
	}

	$url = empty($href) ? (isset($_SERVER['HTTPS']) ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] : $href;

?>
<link rel="canonical" href="<?php echo $url; ?>" />
