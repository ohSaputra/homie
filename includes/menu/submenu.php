<?php
// Theme Name: C88Fin
// Version: 1.0
// Modified: June 19, 2017

    $menu_name = 'C88Fin Menu';
    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );

    $count = 0;
    $submenu = false;

    foreach( $menuitems as $item ):

        $link = $item->url;

        $title = $item->title;
        $menu_parent =  isset($menuitems[ $count + 1 ]->menu_item_parent) ? $menuitems[ $count + 1 ]->menu_item_parent : null;

        $active = get_permalink() === $item->url ? 'active' : null;

        // item does not have a parent so menu_item_parent equals 0 (false)
        if ( !$item->menu_item_parent ):

            // save this id for latesr comparison with sub-menu items
            $parent_id = $item->ID;
            $parent_name = str_replace('/', '', $item->url);

        endif;
        
        if ( $parent_id == $item->menu_item_parent ):

            // get meta title
            $page_id = get_post_meta( $item->ID, '_menu_item_object_id', true );
            $alternative_title = get_post_meta($page_id, 'additional_title', true);
            $submenu_icon = get_post_meta($page_id, 'submenu_icon', true);
        
            if ( !$submenu ): $submenu = true; ?>
        
                <!-- menu starts -->
                <nav class="menu child-menu" role="navigation" id="<?php echo $parent_name; ?>">
                    <ul class="nav nav-grid">

            <?php endif; ?>

            <li class="nav-item <?php echo $active; ?>">
                <a href="<?php echo $link; ?>" class="nav-link">
                    <i class="icon <?php echo $submenu_icon ?>"></i>
                    <strong><?php echo $title; ?></strong>
                    <span><?php echo $alternative_title; ?></span>
                </a>
            </li>

            <?php if ( $menu_parent != $parent_id && $submenu ): ?>

                    </ul>
                </nav>
                <!-- menu ends -->

            <?php $submenu = false; endif;

        endif; 
    $count++; 
    endforeach; ?>