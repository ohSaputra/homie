<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	global $wp_query;

	if (have_posts()) :

		echo '<h1 class="blog-title"><span>'.sprintf(__('Search Results for: %s', 'theme translation'), '<span class="text-dark">'.get_search_query().'</span>').'</span></h1>'."\n";

		get_template_part('includes/form/search', '');

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

		get_template_part('/includes/promos/categories', '');
		get_template_part('/includes/layout/pagination', '');
	
	else :

		echo '<h1 class="blog-title"><span>'.__('Nothing Found', 'theme translation').'</span></h1>'."\n";
		echo '<p class="lead text-center m-b-4x">'.sprintf(__("Sorry, but nothing matched your search for %s; please check your spelling or try again with some different keywords.", "theme translation"), '<span class="text-dark">\''.get_search_query().'\'</span>').'</p>'."\n";
		
		get_template_part('includes/form/search', '');
		
	endif;

?>