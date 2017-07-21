<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	// Define post class

	$entry = new ThemeOptions\Post($post);

	// Fetching category options

	$category = $entry->categories('', 'tag-link');
		
?>

<!-- tags starts -->
    <section class="post-tags">

        <h4 class="blog-title f160"><span><?php echo __('More like this', 'theme translation'); ?></span></h4>

        <?php echo $category['list']; ?>

    </section>
<!-- tags ends -->
