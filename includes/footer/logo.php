<?php
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016


    $output = '';

    $source = get_theme_option('layout_options', 'logo_footer');
    $tagline = get_theme_option('layout_options', 'tagline');
    $description = get_bloginfo('description');

    // $url = home_url();
    $logo = isset($source[0]['url']) ? site_url().$source[0]['url'] : THEME_ASSETS . '/img/c88fin-footer-logo@2x.png';

    if (!empty($logo)) {
        $height = isset($source[0]['output']['height']) ? $source[0]['output']['height'] : '34';
        $width = isset($source[0]['output']['width']) ? $source[0]['output']['width'] : '50';

        $output = '<div class="logo"><img src="'.$logo.'" width="'.$width.'" height="'.$height.'" alt="'.$description.'" /></div>'."\n";
    }
?>

    <!-- logo starts -->
        <?php echo $output; ?>
    <!-- logo ends -->
