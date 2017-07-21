<?php
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016


    if (have_posts()) :

        echo "\n";
        echo '<!-- list starts -->'."\n";
        echo "\t".'<div class="blog-list">'."\n";

        while (have_posts()) : the_post();

            if (post_password_required()) :

                get_template_part('/includes/blog/section', '');

            else :

                get_template_part('/includes/blog/section', '');

            endif;

        endwhile;

        echo "\t".'</div>'."\n";
        echo '<!-- list ends -->'."\n";

        get_template_part('/includes/layout/pagination', '');

    else :

    endif;

?>
<!-- article starts -->
    <article class="article">
        <div class="content container">
            <?php if (have_posts()): ?>

                <?php get_template_part('includes/blog/list', 'index'); ?>

            <?php endif; ?>

        </div>
    </article>
<!-- article ends -->
