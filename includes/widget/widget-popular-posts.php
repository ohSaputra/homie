<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	

	$content = '';
	$output = '';
	
	extract($widget);
	extract($instance);

	$popular = new ThemeOptions\Popular();
	
	$header = empty($title) ? '' : $before_title.$title.$after_title;
	
	$time = isset($instance['time_period']) ? $instance['time_period'] : '';
	$list = $popular->query('post', $time, $instance['list_count'], $instance['category']);

	if (is_array($list->posts) && count($list->posts) >= 1) {

		$output .= '<ol class="post-list">'."\n";

		foreach ($list->posts as $key => $post) {

			$id = $post->ID;
			$meta = get_post_meta($id);

			$image = '';
			$href = get_permalink($id);
			$title = htmlspecialchars($post->post_title);
			$date = sprintf(__('posted on %s', 'admin translation'), current_time(get_option('date_format'), $post->post_date));
			
			$src = get_the_post_thumbnail_url($id, 'thumbnail');
			$src = empty($src) ? esc_url(get_template_directory_uri()).'/img/img-default-320x320.png' : $src;
			$loader = esc_url(get_template_directory_uri()).'/img/img-loader.png';

			$output .= '<li>'."\n";
			$output .= '<figure><img src="'.$loader.'" data-srcset="'.$src.' 1x, '.$src.' 2x" class="lazyload" width="150" height="150" alt="'.$title.'" /></figure>'."\n";
			$output .= '<h5><a href="'.$href.'" title="'.$title.'">'.$title.'</a></h5>'."\n";
			$output .= '<span>'.$date.'</span>'."\n";
			$output .= '</li>'."\n";
		}

		$output .= '</ol>'."\n";
	}

	$content .= $before_widget;
	$content .= $header;
	$content .= '<div class="widget-body">'."\n";
	$content .= $output;
	$content .= '</div>'."\n\n";
	$content .= $after_widget;

	echo $content;

?>
