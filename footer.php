<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Compare_Master
 * @since Compare Master 1.0
 */
?>
            <!-- drawer starts -->
                <div class="layout-drawer" role="drawer">

                    <?php get_template_part('includes/layout/drawer', ''); ?>

                </div>
            <!-- drawer ends -->

            <!-- backdrop starts -->
                <div class="layout-backdrop"></div>
            <!-- backdrop ends -->

        </div>
    <!-- layout ends -->

<?php get_template_part('includes/footer/javascript', ''); ?>
<?php get_template_part('includes/footer/javascript', 'analytics'); ?>
<?php get_template_part('includes/footer/javascript', 'custom'); ?>
<?php wp_footer(); ?>

</body>
</html>