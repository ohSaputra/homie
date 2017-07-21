<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	// Define post class

	$entry = new ThemeOptions\Post($post);

	// Fetching the author

	$author = $entry->author();

	$name = empty($author['name']) ? trim($author['nicename']) : trim($author['name']);
	$name = empty($name) ? __('Anonymous', 'theme translation') : $name;

	$link = '<a href="'.$author['url'].'" title="'.sprintf(__('Find all posts by %s', 'theme translation'), $name).'">'.$name.'</a>'."\n";
	$description = $author['description'];
	
	// Fetching the author avatar
		
	$size = 200;

	$photo = get_the_author_meta('blogg_photo', $author['id']);
	$thumbnail = isset($photo[0]) ? wp_get_attachment_image_src($photo[0]['id'], 'thumbnail') : '';

	$avatar = isset($thumbnail[0]) ? '' : $entry->avatar($size);
	$avatar = isset($thumbnail[0]) ? '<div class="post-avatar"><img src="'.$thumbnail[0].'" width="'.round($size / 2).'" height="'.round($size / 2).'" alt="'.$name.'" /></div>'."\n" : '<div class="post-avatar"><img src="'.$avatar['src'].'" width="'.round($avatar['width'] / 2).'" height="'.round($avatar['height'] / 2).'" alt="'.$name.'" /></div>'."\n";

?>

<h4 class="blog-title f160"><span><?php echo __('Author', 'theme translation'); ?></span></h4>

<!-- author starts -->
    <div class="author-panel" itemscope itemptype="http://schema.org/Person">
    	<?php echo $avatar; ?>
        <div class="author-details">
            <p><span class="author-name" itemprop="name"><?php echo $link; ?></span> <?php echo $description; ?></p>
        </div>
    </div>
<!-- author ends -->
