<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
    

    if (class_exists('bbPress')) :
        
        $hot_threads = '';
        $new_threads = '';

        // Fetching hot topics

        $args = array(

            'post_type'         => 'topic',
            'posts_per_page'    => 8,
            'meta_key'          => '_bbp_reply_count',
            'orderby'           => 'meta_value_num',
            'post_status'       => 'publish',
            'order'             => 'DESC'
        );

        $hot_topics = new WP_Query($args);

        if ($hot_topics->have_posts()) {

            $hot_threads .= '<nav class="blog-nav">'."\n";
            $hot_threads .= '<ul>'."\n";

            while ($hot_topics->have_posts()) : $hot_topics->the_post();

                $title = get_the_title();
                $label = substr($title, 0, 50);

                $hot_threads .= '<li><a href="'.get_the_permalink().'" title="'.$title.'">'.$label.''.(strlen($label) >= 50 ? '...' : '').'</a></li>'."\n";

            endwhile;

            $hot_threads .= '</ul>'."\n";
            $hot_threads .= '</nav>'."\n";
        }

        wp_reset_query();

        // Fetching new topics

        $args = array(

            'post_type'         => 'topic',
            'showposts'         => 8,
            'meta_key'          => '_bbp_last_active_time',
            'orderby'           => 'meta_value',
            'post_status'       => 'publish',
            'order'             => 'DESC'
        );

        $new_topics = new WP_Query($args);

        if ($new_topics->have_posts()) {

            $new_threads .= '<nav class="blog-nav">'."\n";
            $new_threads .= '<ul>'."\n";

            while ($new_topics->have_posts()) : $new_topics->the_post();

                $title = get_the_title();
                $label = substr($title, 0, 50);

                $new_threads .= '<li><a href="'.get_the_permalink().'" title="'.$title.'">'.$label.''.(strlen($label) >= 50 ? '...' : '').'</a></li>'."\n";

            endwhile;

            $new_threads .= '</ul>'."\n";
            $new_threads .= '</nav>'."\n";
        }

        wp_reset_query();
?>

<!-- related starts -->
    <aside class="blog-related">
        
        <h4 class="blog-title f220"><span><?php echo __('Financial Forum', 'theme translation'); ?></span></h4>

        <!-- list starts -->
            <div class="row blog-list">
                <div class="col-sm-6">
                    
                    <h6><?php echo __('Hot threads', 'theme translation'); ?></h6>

                    <?php echo $hot_threads; ?>

                </div>
                <div class="col-sm-6">
                    
                    <h6><?php echo __('New threads', 'theme translation'); ?></h6>

                    <?php echo $new_threads; ?>

                </div>
            </div>
        <!-- list ends -->

    </aside>
<!-- related ends -->

<?php endif; ?>