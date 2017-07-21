<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	$output = '';

	$topics = get_categories();

	if (!empty($topics) && is_array($topics)) {

		foreach ($topics as $key => $topic) {
			
			$output .= '<a href="'.esc_url(get_category_link($topic->term_id)).'" class="tag-link" rel="category tag" title="'.sprintf(__('View all posts in %s', 'theme translation'), $topic->name).'">'.$topic->name.'</a>'."\n";
		}
	}
?>

<!-- tags starts -->
    <section class="post-tags">

        <h4 class="blog-title f160"><span><?php echo __('Topics', 'theme translation'); ?></span></h4>

        <?php echo $output; ?>

    </section>
<!-- tags ends -->
