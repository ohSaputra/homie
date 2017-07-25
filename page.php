<?php
/**
 * The template for displaying a content page
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Compare_Master
 * @since Compare Master 1.0
 */


    $layout = get_post_meta(get_page_id(), 'page_layout', true);

?>
<?php get_header(); ?>

            <!-- content starts -->
                <div class="layout-content">

                    <!-- main starts -->
                        <main class="main" role="main">

                            <?php $page_id = get_page_id(); ?>

                            <?php // except login page and front page ?>
                            <?php if ( is_front_page() === false && $page_id !== 339 ) : ?>

                            <!-- display starts -->
                                <div class="display display-cover display-promo">
                                    <div class="display-content">

                                        <?php get_template_part('includes/menu/breadcrumb', ''); ?>

                                    </div>
                                    <div class="display-graphic">

                                        <?php get_template_part('includes/menu/cover-page', ''); ?>
                                                                                        
                                    </div>
                                </div>
                            <!-- display ends -->

                            <?php endif; ?>

                            <?php if ($layout == 'custom') : ?>

                            <!-- article starts -->
                                <article class="article">
                                    <div class="content container">
                                        
                                        <div class="trend-slider">
                                            <div class="row slider-container">
                                                <div class="col-md-8 left-banner">
                                                </div>
                                                <div class="col-md-4 right-banner"></div>
                                            </div>
                                        </div>

                                        <?php get_template_part('includes/layout/page', ''); ?>

                                    </div>
                                </article>
                            <!-- article ends -->

                                <?php get_template_part('includes/layout/page', ''); ?>

                            <?php elseif ($layout == 'full') : ?>

                            <!-- article starts -->
                                <article class="article">
                                    <div class="content container">

                                        <?php get_template_part('includes/layout/page', ''); ?>

                                    </div>
                                </article>
                            <!-- article ends -->

                            <?php else : ?>

                            <!-- article starts -->
                                <article class="article article-sidebar">
                                    <div class="content container">
                                        <div class="story">
                                            <?php get_template_part('includes/layout/page', ''); ?>
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
