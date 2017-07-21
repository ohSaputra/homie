<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	// Define post class

	$entry = new ThemeOptions\Post($post);

	$title = $entry->title();
	$url = get_permalink($post->ID);
	$domain = get_site_url();

	$facebook_count = '189';
	$twitter_count = '34';
	$google_count = '62';
	$linkedin_count = '0';
	
?>

<hr>

<!-- widget starts -->
    <div class="widget share-widget">

        <h4><?php echo __('Share this page', 'theme translation'); ?></h4>

        <a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>&title=<?php echo $title; ?>" class="share share-facebook share-article" rel="nofollow" target="_blank" title="<?php echo __('Share this page on Facebook', 'theme translation'); ?>"><strong><i class="icon i-social-facebook i-3x"></i><?php echo __('Facebook', 'theme translation'); ?></strong> <span><?php echo $facebook_count; ?></span></a>
        <a href="http://twitter.com/intent/tweet?status=<?php echo $title; ?>+<?php echo $url; ?>" class="share share-twitter share-article" rel="nofollow" target="_blank" title="<?php echo __('Share this page on Twitter', 'theme translation'); ?>"><strong><i class="icon i-social-twitter i-3x"></i><?php echo __('Twitter', 'theme translation'); ?></strong> <span><?php echo $twitter_count; ?></span></a>
        <a href="https://plus.google.com/share?url=<?php echo $url; ?>" class="share share-google share-article" rel="nofollow" target="_blank" title="<?php echo __('Share this page on Google+', 'theme translation'); ?>"><strong><i class="icon i-social-google i-3x"></i><?php echo __('Google', 'theme translation'); ?></strong> <span><?php echo $google_count; ?></span></a>
        <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $title; ?>&source=<?php echo $domain; ?>" class="share share-linkedin share-article" rel="nofollow" target="_blank" title="<?php echo __('Share this page on LinkedIn', 'theme translation'); ?>"><strong><i class="icon i-social-linkedin i-3x"></i><?php echo __('LinkedIn', 'theme translation'); ?></strong> <span><?php echo $linkedin_count; ?></span></a>
    
    </div>
<!-- widget ends -->
