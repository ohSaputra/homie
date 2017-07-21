<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Compare_Master
 * @since Compare Master 1.0
 */

    // Check if we will use a custom error page

    $id = get_theme_option('system_options', 'custom_error_page');
    $layout = get_post_meta($id, 'page_layout', true);

?>
<?php get_header(); ?>

            <!-- content starts -->
                <div class="layout-content">

                    <?php get_template_part('includes/menu/breadcrumb', ''); ?>

                    <!-- main starts -->
                        <main class="main" role="main">

                        <?php if ($layout == 'custom') : ?>

                            <?php get_template_part('includes/layout/404', ''); ?>

                        <?php elseif ($layout == 'full') : ?>

                            <!-- article starts -->
                                <article class="article">
                                    <div class="content">

                                        <?php get_template_part('includes/layout/404', ''); ?>

                                    </div>
                                </article>
                            <!-- article ends -->

                        <?php else : ?>

                            <!-- article starts -->
                                <article class="article article-sidebar">
                                    <div class="content container">
                                        <div class="story">
                                            <?php get_template_part('includes/layout/404', ''); ?>
                                        </div>

                                        <aside class="sidebar sidebar-sticky">
                                            <?php get_sidebar(); ?>
                                        </aside>
                                    </div>
                                </article>
                            <!-- article ends -->

                        <?php endif; ?>

                        </main>
                    <!-- main ends -->

                    <?php get_template_part('includes/layout/footer', ''); ?>

                </div>
            <!-- content ends -->

<?php get_footer(); ?>