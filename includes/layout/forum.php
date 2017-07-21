<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	if (have_posts()) while (have_posts()) : the_post();
		
		if (post_password_required()) : 
			
			get_template_part('/includes/form/password', '');
			
		else :
			
			get_template_part('/includes/forum/title', '');
			get_template_part('/includes/forum/description', '');

			bbp_get_template_part('form', 'search');

			the_content();

		endif;
		
	endwhile;
?>
