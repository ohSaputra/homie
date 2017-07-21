<?php
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016


    namespace ThemeOptions;

    // Sets up a new page with custom theme settings
    //
    // slug 		= The slug name to refer to this menu by (should be a unique variable name for this menu to fetch it's settings in the database)
    // name 		= The text to be used for the menu
    // title 		= The text to be displayed in the title tags of the page when the menu is selected
    // capability	= The capability required for this menu to be displayed to the user
    // icon 		= The icon to be used in the menu, it should be a class name of a wordpress icon, see more here: https://developer.wordpress.org/resource/dashicons/
    // parent 		= The slug name for the parent menu (or the file name of a standard WordPress admin page)
    // position 	= The position in the menu order this one should appear (start number is 100)
    // options 		= The different page options and their included form input fields (an array with a title and child input fields)
    //
    // See detailed menu settings description here: https://developer.wordpress.org/reference/functions/add_menu_page/

    $setup = array (

        'slug'			=> 'layout_options',
        'name'			=> __('Layout', 'admin translation'),
        'title'			=> __('General options', 'admin translation'),
        'capability'	=> 'update_themes',
        'icon'			=> 'dashicons-desktop',
        'parent'		=> '',
        'position'		=> 100,
        'options'		 => array (

            __('Website logo', 'admin translation') => array (

                '0' => array (
                'name'			=> __('Company logo', 'admin translation'),
                'label'			=> 'logo',
                'validation'	=> '',
                'type'			=> 'file',
                'rendering'		=> '',
                'value'			=> '',
                'filetypes'		=> array('png'),
                'output'		=> array('width' => '', 'height' => 46),
                'description'	=> __("Upload a company logo in double pixel size than requires (a minimum height of 92 pixels), to support retina display devices.", 'admin translation')
                ),

                '1' => array (
                'name'			=> __('Tagline', 'admin translation'),
                'label'			=> 'tagline',
                'validation'	=> '',
                'type'			=> 'text',
                'value'			=> '',
                'description'	=> __('Is an option to add a tagline next to the logo.', 'admin translation')
                ),

                '2' => array (
                'name'          => __('Company logo (Footer)', 'admin translation'),
                'label'         => 'logo_footer',
                'validation'    => '',
                'type'          => 'file',
                'rendering'     => '',
                'value'         => '',
                'filetypes'     => array('png'),
                'output'        => array('width' => '', 'height' => ''),
                'description'   => __("Upload a company logo in double pixel size than requires (a minimum height of 68 pixels), to support retina display devices.", 'admin translation')
                ),
            ),

            __('Favicon', 'admin translation') => array (

                '0' => array (
                'name'			=> __('48x48 favicon', 'admin translation'),
                'label'			=> 'favicon',
                'validation'	=> '',
                'type'			=> 'file',
                'rendering'		=> '',
                'value'			=> '',
                'filetypes'		=> array('ico'),
                'description'	=> __("Upload a 48x48 pixel ICO file that will represent our website's favicon.", 'admin translation')
                )
            ),

            __('Apple touch icons', 'admin translation') => array (

                '0' => array (
                'name'			=> __('180x180 icon', 'admin translation'),
                'label'			=> 'apple_touch_180_icon',
                'validation'	=> '',
                'type'			=> 'file',
                'rendering'		=> '',
                'value'			=> '',
                'filetypes'		=> array('png'),
                'description'	=> __('Upload a 180x180 pixel PNG image that will represent our website when our web page is added to the home screen in an iPhone.', 'admin translation')
                ),

                '1' => array (
                'name'			=> __('152x152 icon', 'admin translation'),
                'label'			=> 'apple_touch_152_icon',
                'validation'	=> '',
                'type'			=> 'file',
                'rendering'		=> '',
                'value'			=> '',
                'filetypes'		=> array('png'),
                'description'	=> __('Upload a 152x152 pixel PNG image that will represent our website when our web page is added to the home screen in an iPhone.', 'admin translation')
                ),

                '2' => array (
                'name'			=> __('120x120 icon', 'admin translation'),
                'label'			=> 'apple_touch_120_icon',
                'validation'	=> '',
                'type'			=> 'file',
                'rendering'		=> '',
                'value'			=> '',
                'filetypes'		=> array('png'),
                'description'	=> __('Upload a 120x120 pixel PNG image that will represent our website when our web page is added to the home screen in an iPhone.', 'admin translation')
                ),

                '3' => array (
                'name'			=> __('76x76 icon', 'admin translation'),
                'label'			=> 'apple_touch_76_icon',
                'validation'	=> '',
                'type'			=> 'file',
                'rendering'		=> '',
                'value'			=> '',
                'filetypes'		=> array('png'),
                'description'	=> __('Upload a 76x76 pixel PNG image that will represent our website when our web page is added to the home screen in an iPhone.', 'admin translation')
                ),

                '4' => array (
                'name'			=> __('48x48 icon', 'admin translation'),
                'label'			=> 'apple_touch_48_icon',
                'validation'	=> '',
                'type'			=> 'file',
                'rendering'		=> '',
                'value'			=> '',
                'filetypes'		=> array('png'),
                'description'	=> __('Upload a 48x48 pixel PNG image that will represent our website when our web page is added to the home screen in an iPhone.', 'admin translation')
                )
            ),

            __('Android touch icons', 'admin translation') => array (

                '0' => array (
                'name'			=> __('192x192 icon', 'admin translation'),
                'label'			=> 'android_touch_192_icon',
                'validation'	=> '',
                'type'			=> 'file',
                'rendering'		=> '',
                'value'			=> '',
                'filetypes'		=> array('png'),
                'description'	=> __('Upload a 192x192 pixel PNG image that will represent our website when our web page is added to the home screen in an Android phone.', 'admin translation')
                ),

                '1' => array (
                'name'			=> __('128x128 icon', 'admin translation'),
                'label'			=> 'android_touch_128_icon',
                'validation'	=> '',
                'type'			=> 'file',
                'rendering'		=> '',
                'value'			=> '',
                'filetypes'		=> array('png'),
                'description'	=> __('Upload a 128x128 pixel PNG image that will represent our website when our web page is added to the home screen in an Android phone.', 'admin translation')
                )
            ),

            __('Windows tile icon', 'admin translation') => array (

                '0' => array (
                'name'			=> __('144x144 tile', 'admin translation'),
                'label'			=> 'windows_144_tile',
                'validation'	=> '',
                'type'			=> 'file',
                'rendering'		=> '',
                'value'			=> '',
                'filetypes'		=> array('png'),
                'description'	=> __("Upload a 144x144 pixel PNG image that will represent our website when our web page is added to the home screen in Windows computer.", 'admin translation')
                ),

                '1' => array (
                'name'			=> __('Tile background color', 'admin translation'),
                'label'			=> 'windows_tile_color',
                'validation'	=> '',
                'type'			=> 'color picker',
                'value'			=> 'FFFFFF',
                'description'	=> __('Is an option to set a background color behind the tile image.', 'admin translation')
                )
            )
        )
    );

    new Register($setup);
?>
