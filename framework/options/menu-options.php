<?php
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016


    namespace MenuOptions;

    // Sets up custom menu options
    //
    // slug 		= The slug name used to set up and store menu options (should be a unique variable name)
    // options 		= The different menus to be created and which will be available under the menu handling page
    //
    // name 		= The menu name used in admin panels
    // class 		= The menu location identifier, should be a slug or class name (also used as the menu class).
    // auto 		= The menu settings for auto adding pages, takes a boolean value (true or false).
    // items 		= Option to add pages to the menu once it's registered.
    //
    // See detailed menu settings description here:

    $setup = array (

        'slug' => 'menu_options',
        'options' => array (

            '0' => array (

                'name'          => __('C88Fin Menu', 'admin translation'),
                'class'         => 'page-menu',
                'auto'          => true,
                'items'         => array (

                    '0' => array (
                        'menu-item-title'   => __('Who We Are', 'theme translation'),
                        'menu-item-type'    => 'custom',
                        'menu-item-url'     => '/who-we-are',
                        'menu-item-classes' => '',
                        'menu-item-status'  => 'publish'
                    ),

                    '1' => array (
                        'menu-item-title'   => __('What We Do', 'theme translation'),
                        'menu-item-type'    => 'custom',
                        'menu-item-url'     => '/what-we-do',
                        'menu-item-classes' => '',
                        'menu-item-status'  => 'publish'
                    ),

                    '2' => array (
                        'menu-item-title'   => __('Who We Serve', 'theme translation'),
                        'menu-item-type'    => 'custom',
                        'menu-item-url'     => '/who-we-serve',
                        'menu-item-classes' => '',
                        'menu-item-status'  => 'publish'
                    ),

                    '3' => array (
                        'menu-item-title'   => __('Investor Relations', 'theme translation'),
                        'menu-item-type'    => 'custom',
                        'menu-item-url'     => '/investors',
                        'menu-item-classes' => '',
                        'menu-item-status'  => 'publish'
                    )
                )
            ),

            '1' => array (

                'name'          => __('Foot menu', 'admin translation'),
                'class'         => 'foot-menu',
                'auto'          => false,
                'items'         => array (

                    '0' => array (
                        'menu-item-title'   => __('Who We Are', 'theme translation'),
                        'menu-item-type'    => 'custom',
                        'menu-item-url'     => '/who-we-are',
                        'menu-item-classes' => '',
                        'menu-item-status'  => 'publish'
                    ),

                    '1' => array (
                        'menu-item-title'   => __('What We Do', 'theme translation'),
                        'menu-item-type'    => 'custom',
                        'menu-item-url'     => '/what-we-do',
                        'menu-item-classes' => '',
                        'menu-item-status'  => 'publish'
                    ),

                    '2' => array (
                        'menu-item-title'   => __('Who We Serve', 'theme translation'),
                        'menu-item-type'    => 'custom',
                        'menu-item-url'     => '/who-we-serve',
                        'menu-item-classes' => '',
                        'menu-item-status'  => 'publish'
                    ),

                    '3' => array (
                        'menu-item-title'   => __('Investor Relations', 'theme translation'),
                        'menu-item-type'    => 'custom',
                        'menu-item-url'     => '/investors',
                        'menu-item-classes' => '',
                        'menu-item-status'  => 'publish'
                    )
                )
            )

        )
    );

    new Register($setup);
?>
