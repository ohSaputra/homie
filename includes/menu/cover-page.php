<?php
// Theme Name: C88Fin
// Version: 1.0
// Modified: June 16, 2017

    // check image thumnail

    if (has_post_thumbnail( $post->ID ) ) :

        // get image

        $cover_page = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>

        <figure class="media-cover cover-middle"><img src="/wp-content/themes/c88fin/img/img-loader.png" data-srcset="<?php echo $cover_page[0]; ?> 1x, <?php echo $cover_page[0]; ?> 2x" class="lazyload" width="1280" height="410" alt="" /></figure>

<?php endif; ?>