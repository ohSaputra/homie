<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	

    $i = 0;
    $output[0] = '';
    $output[1] = '';
    
    $categories = get_categories();
    $chunks = array_chunk($categories, ceil(count($categories) / 2), true);

    $postcount = false;

    if (! empty($chunks)) {

        foreach ($chunks as $chunk) {

            $output[$i] .= '<nav class="blog-nav">'."\n";
            $output[$i] .= '<ul>'."\n";

            foreach ($chunk as $value) {
                
                $url = get_category_link($value->term_id);
                $count = $postcount ? ' <span class="text-label">('.$value->category_count.')</span>' : '';

                $output[$i] .= '<li><a href="'.$url.'" title="'.sprintf(__('Read posts about %s', 'theme translation'), $value->name).'">'.$value->name.'</a>'.$count.'</li>'."\n";
            }

            $output[$i] .= '</ul>'."\n";
            $output[$i] .= '</nav>'."\n";

            $i += 1;
        }
    }

?>

<!-- related starts -->
    <aside class="blog-related">
        
        <h4 class="blog-title f220"><span><?php echo __('Categories', 'theme translation'); ?></span></h4>

        <!-- list starts -->
            <div class="row blog-list">
                <div class="col-sm-6">
                        
                    <?php echo $output[0]; ?>
                        
                </div>
                <div class="col-sm-6">
                    
                    <?php echo $output[1]; ?>

                </div>
            </div>
        <!-- list ends -->

    </aside>
<!-- related ends -->
                                        