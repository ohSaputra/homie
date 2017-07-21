<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	

	if (wp_attachment_is_image()) : 

		$metadata = wp_get_attachment_metadata($post->ID);
		$image = wp_get_attachment_image($post->ID);

		$url = wp_upload_dir();
		$image = '<img src="'.$url['baseurl'].'/'.$metadata['file'].'" width="'.$metadata['width'].'" height="'.$metadata['height'].'" alt="'.get_post_meta($post->ID, '_wp_attachment_image_alt', true).'" />';
		$caption = empty($post->post_excerpt) ? '' : '<figcaption>'.$post->post_excerpt.'</figcaption>';
		$content = empty($post->post_content) ? '' : '<p>'.$post->post_content.'</p>';
?>

	<!-- attachment starts -->
        <div class="attachment">
        
            <!-- image starts -->
                <figure class="image"><?php echo $image; ?><?php echo $caption; ?></figure>
            <!-- image ends -->
            
            <?php echo $content; ?>
            
        </div>
    <!-- attachment ends -->

<?php else : ?>

	<?php echo wp_get_attachment_link($post->ID, true); ?>

<?php endif; ?>

