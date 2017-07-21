<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	

	$content = '';
	
	extract($widget);
	extract($instance);
	
	$header = empty($title) ? '' : $before_title.$title.$after_title;
	$alt = isset($media[0]['alt']) ? $media[0]['alt'] : $title;
	$src = isset($media[0]['url']) ? $media[0]['url'] : '';
	$ratio = isset($media[0]['ratio']) ? $media[0]['ratio'] : 1.5;

	$width = 296;
	$height = round($width / $ratio);

	$href = empty($url) ? '' : $url;
	$target = get_target_attribute($href);

	$loader = esc_url(get_template_directory_uri()).'/img/img-loader.png';

	$image = empty($src) ? '' : '<img src="'.$loader.'" data-srcset="'.$src.' 1x, '.$src.' 2x" class="lazyload" width="'.$width.'" height="'.$height.'" alt="'.$alt.'" />';
	$image = empty($href) ? $image : '<a href="'.$href.'"'.$target.'>'.$image.'</a>';
	$figure = empty($src) ? '' : '<figure class="widget-graphic">'.$image.'</figure>'."\n";

	$content .= $before_widget;
	$content .= $header."\n";
	$content .= '<div class="widget-body">'."\n";
	$content .= $figure;
	$content .= '</div>'."\n\n";
	$content .= $after_widget;
	
	echo $content;
?>
