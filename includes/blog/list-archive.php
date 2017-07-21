<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	global $wp_query;

	if (have_posts()) :
		
		$type = get_page_type();

		switch ($type) {

			case 'author':

				$author = get_the_author_meta('user_firstname').' '.get_the_author_meta('user_lastname');
				$author = empty(trim($author)) ? get_the_author_meta('nickname') : $author;

				$title = '<h1 class="blog-title"><span>'.$author.'</span></h1>'."\n";
				$description = '<p class="lead text-center m-b-4x">'.sprintf(__("These are all our collected articles written by %s, so have a look and enjoy your reading.", "theme translation"), '<span class="text-dark">'.$author.'</span>').'</p>'."\n";

			break;
			case 'archive':

				$title = '<h1 class="blog-title"><span>'.get_page_title().'</span></h1>'."\n";
				$description = '';

			break;
			case 'tag':

				$title = '<h1 class="blog-title"><span>'.trim(wp_title('', false, '')).'</span></h1>'."\n";
				$description = '';

			break;
			default:
					
				$title = '';
				$description = '';
				
			break;
		}
		
		echo $title;
		echo $description;

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

		get_template_part('/includes/layout/pagination', '');
	
	else :

		echo '<h1 class="blog-title"><span>'.__('Nothing Found', 'theme translation').'</span></h1>'."\n";
		echo '<p class="lead text-center m-b-4x">'.__("Sorry, but nothing matched your archive request; please check your spelling or try again with a different archive.", "theme translation").'</p>'."\n";
		
	endif;

?>