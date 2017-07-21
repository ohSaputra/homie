<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	

	$content = '';
	
	extract($widget);
	extract($instance);
	
	$title = empty($title) ? '' : '<h4>'.$title.'</h4>'."\n";
	$text = empty($text) ? '' : '<p class="m-b-2x">'.$text.'</p>'."\n";
	$terms = empty($terms) ? '' : '<span class="btn-label m-t-1x m-b-0 f100 o70">'.$terms.'</span>'."\n";

	$alt = isset($media[0]['alt']) ? $media[0]['alt'] : $title;
	$src = isset($media[0]['url']) ? $media[0]['url'] : '';
	$ratio = isset($media[0]['ratio']) ? $media[0]['ratio'] : 1.5;

	$width = 296;
	$height = round($width / $ratio);
	$loader = esc_url(get_template_directory_uri()).'/img/img-loader.png';

	$image = empty($src) ? '' : '<img src="'.$loader.'" data-srcset="'.$src.' 1x, '.$src.' 2x" class="lazyload" width="'.$width.'" height="'.$height.'" alt="'.$alt.'" />';
	$figure = empty($src) ? '' : '<figure class="widget-graphic">'.$image.'</figure>'."\n";

	$href = empty($link) ? '' : get_content_url($link);
	$target = get_target_attribute($href);

	$label = empty($label) ? __('Subscribe', 'theme translation') : $label;

?>

<!-- widget starts -->
    <div class="widget panel-widget bg-subscribe text-plain">

        <?php echo $figure; ?>
        <?php echo $title; ?>
        <?php echo $text; ?>

        <!-- form starts -->
            <form class="subscribe-widget-form" action="/" method="post" data-action="subscribe-widget-form" role="form" novalidate>
                <fieldset>

                    <div class="form-group">
                        <label class="sr-only" for="subscribe-email"><?php echo __('Email Address', 'theme translation'); ?></label>
                        <input type="text" class="text required form-control plain" name="subscribe-email" id="subscribe-email" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" tabindex="1" placeholder="<?php echo __('Type your Email', 'theme translation'); ?>" value="" />
                    </div>

                    <button type="submit" class="btn btn-default btn-block" name="submit" tabindex="2" data-label="<?php echo $label; ?>"><?php echo $label; ?></button>
                    
                    <?php echo $terms; ?>

                </fieldset>
            </form> 
        <!-- form ends -->

    </div>
<!-- widget ends -->
