<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	// Define post class

	$entry = new ThemeOptions\Post($post);

	// Fetching content options

	$title = $entry->title(999);
	
	// Fetching blog date

	$date = $entry->date();
	$time = '<span>'.__('on', 'theme translation').' <time class="post-date" datetime="'.$date['datetime'].'" title="'.$date['posted'].'">'.$date['date'].'</time></span>'."\n";
	
	// Fetching the author

	$author = $entry->author();
	$name = '<span>'.__('by', 'theme translation').' '.(empty(trim($author['name'])) ? $author['nicename'] : $author['name']).'</span>'."\n";


	// Fetching media cover options

	$cover = $entry->cover('post-large');

	// Fetching reading time

	$reading = $entry->reading();
	$reading = '<span class="m-b-4x"><i class="icon i-action-time-thick i-left i-20"></i> '.sprintf(__('%s read', 'theme translation'), $reading).'</span>'."\n";

?>

	<!-- promo starts -->
        <aside class="promo promo-cover promo-blur post-promo white-content promo-h340">
            <div class="promo-content">
                
                <?php echo $reading; ?>
                <h1><?php echo $title; ?></h1>

                <div class="promo-meta">
                    <div class="post-details">
                        <?php echo $name; ?>
                        <?php echo $time; ?>
                    </div>
                </div>

            </div>
            <div class="promo-graphic">

                <?php echo $cover; ?>
                
            </div>
        </aside>
    <!-- promo ends -->
