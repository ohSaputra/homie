<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
    
    /**
     * Feteches posts within a certain date period (useful queries)
     *
     * @param date_query       - 2 week ago
     * @param date_query       - 3 week ago
     * @param date_query       - 30 days ago
     * @param date_query       - 90 days ago
     * @param date_query       - 180 days ago
     *
     */

    $output = array();
    $categories = wp_get_post_categories($post->ID);

    $history = get_theme_option('blog_options', 'post_history');
    $history = empty($history) ? '2 week ago' : $history;
    
    $args = array(

        'cat' => implode(',', $categories),
        'date_query' => array(array('after' => $history)),
        'posts_per_page' => -1,
        'order' => 'DESC'
    );

    $list = new \WP_Query($args);
    $fetch = get_random_number(0, count($list->posts) - 1, 3);

    if (is_array($list->posts) && count($list->posts) >= 1) {

        foreach ($fetch as $key => $number) {

            $post = isset($list->posts[$number]) ? $list->posts[$number] : '';

            if (! empty($post)) {
                
                $id = $post->ID;
                $meta = get_post_meta($id);

                $image = '';
                $href = get_permalink($id);
                $title = htmlspecialchars($post->post_title);
                $date = sprintf(__('posted on %s', 'admin translation'), current_time(get_option('date_format'), $post->post_date));
                
                $src = get_the_post_thumbnail_url($id, 'post-medium');
                $src = empty($src) ? esc_url(get_template_directory_uri()).'/img/img-default-640x320.png' : $src;
                $loader = esc_url(get_template_directory_uri()).'/img/img-loader.png';

                $thumbnail_id = get_post_thumbnail_id($id);
                $file = empty($thumbnail_id) ? '' : get_file_path($thumbnail_id);
                
                $width = 340;
                $height = round($width / get_image_ratio($file));

                $terms = wp_get_post_categories($post->ID);
                $term = get_category($terms[0]);

                $widget = '';

                $widget .= '<figure class="post-figure"><a href="'.$href.'" title="'.$title.'"><img src="'.$loader.'" data-srcset="'.$src.' 1x, '.$src.' 2x" class="lazyload" width="'.$width.'" height="'.$height.'" alt="'.$title.'" /></a></figure>'."\n";
                $widget .= '<span><a href="'.get_category_link($term->term_id).'" title="'.sprintf(__('View all posts in %s', 'theme translation'), $term->name).'">'.$term->name.'</a></span>'."\n";
                $widget .= '<h4 class="h6"><a href="'.$href.'">'.$title.'</a></h4>'."\n";

                array_push($output, $widget);
            }
        }
    }

?>

<!-- related starts -->
    <aside class="blog-panel related-posts">
        <div class="container">
            
            <h4 class="blog-title f160"><span><?php echo __('You might also like', 'theme translation'); ?></span></h4>

            <div class="row row-wide">
                <div class="col-xs-12 col-sm-4">

                    <!-- widget starts -->
                        <div class="widget blog-widget">                            

                            <?php echo isset($output[0]) ? $output[0] : ''; ?>

                        </div>
                    <!-- widget ends -->

                </div>
                <div class="col-xs-12 col-sm-4">

                    <!-- widget starts -->
                        <div class="widget blog-widget">

                            <?php echo isset($output[1]) ? $output[1] : ''; ?>

                        </div>
                    <!-- widget ends -->

                </div>
                <div class="col-xs-12 col-sm-4">

                    <!-- widget starts -->
                        <div class="widget blog-widget">

                            <?php echo isset($output[2]) ? $output[2] : ''; ?>

                        </div>
                    <!-- widget ends -->

                </div>
            </div>

        </div>
    </aside>
<!-- related ends -->

