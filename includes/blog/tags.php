<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	$output = '';

	$tags = get_tags();

	if (!empty($tags) && is_array($tags)) {

		foreach ($tags as $key => $tag) {
			
			$output .= '<a href="'.esc_url(get_category_link($tag->term_id)).'" class="tag-link" rel="category tag" title="'.sprintf(__('View all posts in %s', 'theme translation'), $tag->name).'">'.$tag->name.'</a>'."\n";
		}
	}
?>

<!-- tags starts -->
    <section class="post-tags">

        <h4 class="blog-title f160"><span><?php echo __('Topics', 'theme translation'); ?></span></h4>

        <?php echo $output; ?>

    </section>
<!-- tags ends -->
