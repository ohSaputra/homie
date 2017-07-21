<?php
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016


    $string = get_theme_option('microdata_options', 'copyright_text');

    $output = preg_replace('/\n(\s*\n)+/', '</span>'."\n".'<span>', trim($string));
    $output = '<span>'.preg_replace('/[\n\r]/', '', $output).'</span>'."\n";

?>

    <!-- copyright starts -->
        <div class="copyright pull-left">

                <?php echo $output; ?>

        </div>
    <!-- copyright ends -->
