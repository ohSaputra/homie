<?php
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016


    $output = '';
    $items = '';

    $facebook = get_theme_option('open_graph_options', 'facebook_url');
    $items .= empty($facebook) ? '' : '<li class="nav-item"><a href="'.$facebook.'" class="nav-link facebook" target="_blank" itemprop="sameAs" title="'.__('Like us on Facebook', 'theme translation').'"><i class="icon i-social-facebook i-3x">'.__('Facebook', 'theme translation').'</i></a></li>'."\n";

    $twitter = get_theme_option('open_graph_options', 'twitter_url');
    $items .= empty($twitter) ? '' : '<li class="nav-item"><a href="'.$twitter.'" class="nav-link twitter" target="_blank" itemprop="sameAs" title="'.__('Like us on Twitter', 'theme translation').'"><i class="icon i-social-twitter i-3x">'.__('Twitter', 'theme translation').'</i></a></li>'."\n";

    $google = get_theme_option('open_graph_options', 'google_url');
    $items .= empty($google) ? '' : '<li class="nav-item"><a href="'.$google.'" class="nav-link google" target="_blank" itemprop="sameAs" title="'.__('Like us on Google Plus', 'theme translation').'"><i class="icon i-social-google i-3x">'.__('Google Plus', 'theme translation').'</i></a></li>'."\n";

    $linkedin = get_theme_option('open_graph_options', 'linkedin_url');
    $items .= empty($linkedin) ? '' : '<li class="nav-item"><a href="'.$linkedin.'" class="nav-link linkedin" target="_blank" itemprop="sameAs" title="'.__('Like us on Linkedin', 'theme translation').'"><i class="icon i-social-linkedin i-3x">'.__('Linkedin', 'theme translation').'</i></a></li>'."\n";

    $rss = get_theme_option('open_graph_options', 'rss_url');
    $items .= empty($rss) ? '' : '<li class="nav-item"><a href="'.$rss.'" class="nav-link rss" target="_blank" itemprop="sameAs" title="'.__('Follow our Blog', 'theme translation').'"><i class="icon i-social-rss i-3x">'.__('RSS Feed', 'theme translation').'</i></a></li>'."\n";

    $output .= empty($items) ? '' : '<ul class="nav nav-pills">'."\n";
    $output .= empty($items) ? '' : $items;
    $output .= empty($items) ? '' : '</ul>'."\n";
?>

	<!-- menu starts -->
        <div class="social-menu">
            <?php echo $output; ?>
        </div>
    <!-- menu ends -->
