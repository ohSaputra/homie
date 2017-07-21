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

		'slug'			=> 'forum_options',
		'name'			=> __('Forum', 'admin translation'),
		'title'			=> __('Forum options', 'admin translation'),
		'capability'	=> 'update_themes',
		'icon'			=> 'dashicons-desktop',
		'parent'		=> 'layout_options',
		'position'		=> 102,
		'options'		 => array (

			__('Forum introduction', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Title', 'admin translation'),
				'label'			=> 'forum_title',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This is an option to add a forum title to the forum overview page.", 'admin translation')
				),

				'1' => array (
				'name'			=> __('Description', 'admin translation'),
				'label'			=> 'forum_description',
				'validation'	=> '',
				'maximum'		=> '',
				'rows'			=> '4',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> __("This is an option to add a forum description to the forum overview page.", 'admin translation')
				),
			)
		)
	);
	
	if (class_exists('bbPress')) :
		
		new Register($setup);
	
	endif;
?>