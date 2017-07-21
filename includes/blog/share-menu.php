<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	// Define post class

	$entry = new ThemeOptions\Post($post);

	$title = $entry->title();
	$url = get_permalink($post->ID);
	$domain = get_site_url();
	
?>

<!-- sharing starts -->
    <div class="sharing">

        <strong class="title"><?php echo __('Share this', 'theme translation'); ?></strong>
        <ul class="list-inline">
            <li><a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>&title=<?php echo $title; ?>" class="share share-button share-facebook" rel="nofollow" target="_blank" title="<?php echo __('Share this page on Facebook', 'theme translation'); ?>"><i class="icon i-social-facebook i-2x"><?php echo __('Facebook', 'theme translation'); ?></i></a></li>
            <li><a href="http://twitter.com/intent/tweet?status=<?php echo $title; ?>+<?php echo $url; ?>" class="share share-button share-twitter" rel="nofollow" target="_blank" title="<?php echo __('Share this page on Twitter', 'theme translation'); ?>"><i class="icon i-social-twitter i-2x"><?php echo __('Twitter', 'theme translation'); ?></i></a></li>
            <li><a href="https://plus.google.com/share?url=<?php echo $url; ?>" class="share share-button share-google" rel="nofollow" target="_blank" title="<?php echo __('Share this page on Google+', 'theme translation'); ?>"><i class="icon i-social-google i-2x"><?php echo __('Google+', 'theme translation'); ?></i></a></li>
            <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $title; ?>&source=<?php echo $domain; ?>" class="share share-button share-linkedin" rel="nofollow" target="_blank" title="<?php echo __('Share this page on LinkedIn', 'theme translation'); ?>"><i class="icon i-social-linkedin i-2x"><?php echo __('LinkedIn', 'theme translation'); ?></i></a></li>
        </ul>

    </div>
<!-- sharing ends -->
