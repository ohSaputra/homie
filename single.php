<?php
/**
 * The template for displaying a single blog post
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Compare_Master
 * @since Compare Master 1.0
 */

?>
<?php get_header(); ?>

            <!-- content starts -->
                <div class="layout-content">

                    <!-- main starts -->
                        <main class="main" role="main">

                            <?php get_template_part('includes/menu/breadcrumb', ''); ?>
                            <?php get_template_part('includes/blog/promo', ''); ?>

                            <!-- article starts -->
                                <article class="article article-sidebar">
                                    <div class="content container">

                                        <div class="story">
                                            <?php get_template_part('includes/blog/post', ''); ?>
                                        </div>

                                        <aside class="sidebar">

                                            <?php get_sidebar(); ?>

                                        </aside>

                                    </div>

                                </article>
                            <!-- article ends -->

                            <?php get_template_part('includes/blog/post', 'related'); ?>

                        </main>
                    <!-- main ends -->

                    <?php get_template_part('includes/layout/footer', ''); ?>

                </div>
            <!-- content ends -->

<?php get_footer(); ?>
