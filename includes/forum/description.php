<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$content = is_category() ? category_description() : get_theme_option('forum_options', 'forum_description');
	$output = empty($content) ? '' : '<p class="lead text-center m-b-4x">'.strip_tags(nl2br($content), '<a><br><strong>').'</p>'."\n";
?>
<?php echo $output; ?>
