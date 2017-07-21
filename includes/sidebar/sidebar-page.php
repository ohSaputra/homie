<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$id = get_page_id();
	
	$active = isset($id) ? get_post_meta($id, 'active_sidebar', true) -1 : -1;
	$sidebars = get_theme_option('blog_options', 'custom_sidebars');

	$password = post_password_required();

	if (empty($password)) {

		if (!empty($sidebars) && is_array($sidebars)) {

			$sidebar = ($active >= 0) ? sanitize_title($sidebars[$active]) : '';

			if (is_active_sidebar($sidebar)) { dynamic_sidebar($sidebar); } else if (is_active_sidebar('page-widgets')) { dynamic_sidebar('page-widgets'); } else { echo '&nbsp;'; };
		}
		else {
			
			if (is_active_sidebar('page-widgets')) { dynamic_sidebar('page-widgets'); } else { echo '&nbsp;'; };
		}
	}
	else {

		echo '&nbsp;';
	}
?>
