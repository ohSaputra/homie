<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "layout-content" div.
 *
 * @package WordPress
 * @subpackage Compare_Master
 * @since Compare Master 1.0
 */
?>
<!doctype html>
<html lang="<?php $language = explode('-', get_bloginfo('language')); echo $language[0]; ?>"<?php if(is_rtl()) : echo ' dir="rtl"'; endif; ?>>
<head>

<meta charset="utf-8">
<title><?php get_template_part('includes/header/meta', 'title'); ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<?php get_template_part('includes/header/favicon', 'windows'); ?>

<?php get_template_part('includes/header/meta', 'robots'); ?>
<?php get_template_part('includes/header/meta', 'description'); ?>
<?php get_template_part('includes/header/meta', 'keywords'); ?>
<?php get_template_part('includes/header/meta', 'copyright'); ?>
<?php get_template_part('includes/header/meta', 'author'); ?>

<?php get_template_part('includes/header/meta', 'twitter'); ?>
<?php get_template_part('includes/header/meta', 'facebook'); ?>
<?php get_template_part('includes/header/meta', 'itemprop'); ?>

<?php get_template_part('includes/header/verification', 'google'); ?>
<?php get_template_part('includes/header/verification', 'bing'); ?>
<?php get_template_part('includes/header/verification', 'alexa'); ?>

<?php get_template_part('includes/header/favicon', ''); ?>
<?php get_template_part('includes/header/favicon', 'apple'); ?>
<?php get_template_part('includes/header/favicon', 'android'); ?>

<?php get_template_part('includes/header/meta', 'google'); ?>

<?php get_template_part('includes/header/link', 'pingback'); ?>
<?php get_template_part('includes/header/link', 'canonical'); ?>
<?php get_template_part('includes/header/link', ''); ?>

<?php wp_head(); ?>

</head>

<body>

    <!-- layout starts -->
        <div class="layout">

            <!-- header starts -->
                <header class="layout-header" role="banner">

                    <?php get_template_part('includes/layout/head', ''); ?>

                    <!-- toggle starts -->
                        <div class="toggle-menu">
                            <div class="container">

                                <?php get_template_part('includes/menu/submenu', ''); ?>

                            </div>
                        </div>
                    <!-- toggle ends -->

                </header>
            <!-- header ends -->