<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	// Define post class

	$entry = new ThemeOptions\Post($post);

	// Fetching content options

	$title = $entry->title();
	$text = $entry->text();
	$url = get_permalink($post->ID);
	$label = $entry->label();
	
	// Fetching blog date

	$date = $entry->date();
	$time = '<time class="post-date" datetime="'.$date['datetime'].'" title="'.$date['posted'].'">'.$date['date'].'</time>'."\n";

	// Fetching comment options

	$comment = $entry->comments();
	$comments = comments_open() ? '<a href="'.$comment['url'].'" class="post-comments" title="'.$comment['label'].'">'.$comment['link'].'</a>' : '';

	// Fetching category options

	$category = $entry->categories();
	$categories = str_replace(',', ' |', $category['list']);

	// Fetching media options

	$media = $entry->media('post-large');

	// Fetching the author

	$author = $entry->author();

	$name = empty(trim($author['name'])) ? $author['nicename'] : $author['name'];
	$bio = '<strong class="post-author"><span>'.__('By', 'theme translation').':</span> <a href="'.$author['url'].'" title="'.sprintf(__('Find all posts by %s', 'theme translation'), $name).'">'.$name.'</a></strong>'."\n";
	
	// Fetching the author avatar

	$avatar = $entry->avatar(160);
	$avatar = '<div class="post-avatar"><a href="'.$author['url'].'" title="'.sprintf(__('Find all posts by %s', 'theme translation'), $name).'"><img src="'.$avatar['src'].'" height="'.round($avatar['height'] / 2).'" width="'.round($avatar['width'] / 2).'" alt="'.$name.'" /></a></div>'."\n";

?>
	
	<!-- entry starts -->
	    <section class="blog-entry">
	        
	        <?php echo $media; ?>

	        <div class="post-bio">
	            <?php echo $avatar; ?>
	            <?php echo $bio; ?>
	            <?php echo $time; ?>
	        </div>

	        <h3><a href="<?php echo $url; ?>" title="<?php echo $label; ?>"><?php echo $title; ?></a></h3>
	        <div class="post-meta"><?php echo $categories; ?></div>
	        <p><?php echo $text; ?></p>
	        <a href="<?php echo $url; ?>" class="btn btn-ghost-default" title="<?php echo $label; ?>"><?php echo $label; ?></a>

	    </section>
	<!-- entry ends -->
