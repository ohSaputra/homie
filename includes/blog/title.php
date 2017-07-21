<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	

	$content = is_category() ? single_cat_title('', false) : get_theme_option('blog_options', 'blog_title');
	$output = empty($content) ? '' : '<h1 class="blog-title"><span>'.strip_tags(nl2br($content), '<a><br><strong>').'</span></h1>'."\n";
?>
<?php echo $output; ?>
