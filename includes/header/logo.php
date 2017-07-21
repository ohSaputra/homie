<?php
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016


    $output = '';

    $source = get_theme_option('layout_options', 'logo');
    $tagline = get_theme_option('layout_options', 'tagline');
    $description = get_bloginfo('description');

    $url = home_url();
    $logo = isset($source[0]['url']) ? site_url().$source[0]['url'] : THEME_ASSETS . '/img/c88fin-logo@2x.png';

    if (!empty($logo)) {

        $height = isset($source[0]['output']['height']) ? $source[0]['output']['height'] : '46';
        $width = isset($source[0]['ratio']) ? round($height * $source[0]['ratio']) : '68';

        $output = '<a href="'.$url.'" class="logo"><img src="'.$logo.'" width="'.$width.'" height="'.$height.'" alt="'.$description.'" /></a>'."\n";
    }
?>

    <!-- logo starts -->
        <?php echo $output; ?>
    <!-- logo ends -->
