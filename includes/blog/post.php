<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	if (have_posts()) while (have_posts()) : the_post();
		
		if (post_password_required()) : 
			
			get_template_part('/includes/form/password', '');
			
		else :
			
			get_template_part('includes/blog/intro', '');

			the_content();

			get_template_part('includes/blog/author', '');
			get_template_part('includes/blog/share', '');
			get_template_part('includes/disqus/comments', '');
		
		endif;
		
	endwhile;

?>