<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	

	$content = '';
	
	extract($widget);
	extract($instance);
	
	$name = empty($name) ? '' : '<strong>'.$name.'</strong>';
	$job = empty($job_title) ? '' : '<span>'.$job_title.'</span>';
	$testimonial = empty($testimonial) ? '' : $testimonial;
	
	$width = 70;
	$height = 70;

	$id = isset($media[0]['id']) ? $media[0]['id'] : '';
	$src = isset($id) ? wp_get_attachment_image_src($id, 'thumbnail') : '';
	$alt = empty($job) ? $instance['name'] : $instance['name'].' - '.$instance['job_title'];
	
	$image = empty($src[0]) ? '' : '<img src="'.$src[0].'" width="'.$width.'" height="'.$height.'" alt="'.$alt.'" />';
	
?>

<!-- widget starts -->
    <div class="widget testimonial-widget">
        <blockquote class="testimonial">
            <p><span class="center-block p-b-1x"><i class="icon i-display-speech i-4x"></i></span><?php echo $testimonial; ?></p>
            <cite><?php echo $image; ?><?php echo $name; ?> <?php echo $job; ?></cite>
        </blockquote>
    </div>
<!-- widget ends -->
