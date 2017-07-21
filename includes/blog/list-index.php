<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	

	global $wp_query;
	
	if (have_posts()) :
		
		get_template_part('/includes/blog/title', '');
		get_template_part('/includes/blog/description', '');

		query_posts('showposts=10');

		$max = count($wp_query->posts);
		$page = isset($wp_query->query['paged']) ? $wp_query->query['paged'] : 1;
		$count = 0;

		while (have_posts()) : the_post();
			
			if ($count === 4) {

				get_template_part('/includes/promos/newsletter', '');
			}

			if ($count % 2 === 0) {

				echo "\n";
				echo '<!-- list starts -->'."\n";
				echo "\t".'<div class="row blog-list">'."\n";
				echo "\t\t".'<div class="col-sm-6">'."\n";

				get_template_part('/includes/blog/section', '');

				echo "\t\t".'</div>'."\n";
			}

			if ($count % 2 === 1) {
				
				echo "\t\t".'<div class="col-sm-6">'."\n";

				get_template_part('/includes/blog/section', '');

				echo "\t\t".'</div>'."\n";
				echo "\t".'</div>'."\n";
				echo '<!-- list ends -->'."\n";
				echo "\n";
			}

			if ($count + 1 === $max && $count % 2 != 1) {
				
				echo "\t\t".'<div class="col-sm-6">'."\n";
				echo '&nbsp;'."\n";
				echo "\t\t".'</div>'."\n";
				echo "\t".'</div>'."\n";
				echo '<!-- list ends -->'."\n";
				echo "\n";
			}

			$count++;
			
		endwhile;

		get_template_part('/includes/blog/topics', '');
		get_template_part('/includes/forum/threads', '');

	else :
		
	endif;

?>