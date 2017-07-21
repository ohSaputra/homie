<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	

	$content = '';
	
	extract($widget);
	extract($instance);
	
	$title = empty($title) ? '' : '<h4>'.$title.'</h4>'."\n";
	$text = empty($text) ? '' : '<p class="m-b-2x">'.$text.'</p>'."\n";

	$alt = isset($media[0]['alt']) ? $media[0]['alt'] : $title;
	$src = isset($media[0]['url']) ? $media[0]['url'] : '';
	$ratio = isset($media[0]['ratio']) ? $media[0]['ratio'] : 1.5;

	$width = 296;
	$height = round($width / $ratio);
	$loader = esc_url(get_template_directory_uri()).'/img/img-loader.png';

	$image = empty($src) ? '' : '<img src="'.$loader.'" data-srcset="'.$src.' 1x, '.$src.' 2x" class="lazyload" width="'.$width.'" height="'.$height.'" alt="'.$alt.'" />';
	$figure = empty($src) ? '' : '<figure class="widget-graphic">'.$image.'</figure>'."\n";

	$href = empty($url) ? '' : $url;
	$target = get_target_attribute($href);

	$label = empty($label) ? '' : $label;
	$button = empty($href) || empty($label) ? '' : '<a href="'.$href.'" class="btn btn-secondary btn-block"'.$target.'><span>'.$label.'</span></a>'."\n";

	$before_widget = str_replace('post-widget', 'post-widget panel-widget', $before_widget);

	$content .= $before_widget;
	$content .= $figure;
	$content .= $title;
	$content .= $text;
	$content .= $button;
	$content .= $after_widget;
	
	echo $content;
?>
