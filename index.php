<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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

                    <?php //get_template_part('includes/menu/breadcrumb', ''); ?>

                    <!-- main starts -->
                        <main class="main" role="main">

                            <?php get_template_part('includes/layout/index', ''); ?>

                        </main>
                    <!-- main ends -->

                    <?php get_template_part('includes/layout/footer', ''); ?>

                </div>
            <!-- content ends -->

<?php get_footer(); ?>
