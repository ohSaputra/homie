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

		'slug'			=> 'blog_options',
		'name'			=> __('Blog', 'admin translation'),
		'title'			=> __('Blog options', 'admin translation'),
		'capability'	=> 'update_themes',
		'icon'			=> 'dashicons-desktop',
		'parent'		=> 'layout_options',
		'position'		=> 101,
		'options'		 => array (

			__('Blog introduction', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Title', 'admin translation'),
				'label'			=> 'blog_title',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This is an option to add a blog title to the blog overview page.", 'admin translation')
				),

				'1' => array (
				'name'			=> __('Description', 'admin translation'),
				'label'			=> 'blog_description',
				'validation'	=> '',
				'maximum'		=> '',
				'rows'			=> '4',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> __("This is an option to add a blog description to the blog overview page.", 'admin translation')
				),
			),

			__('Post display', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Post excerpt', 'admin translation'),
				'label'			=> 'post_excerpt',
				'validation'	=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> array(__('Use article text', 'admin translation'), __('Use excerpt text', 'admin translation')),
				'description'	=> __("Is an option to select the excerpt text of a post page, i.e. if it should be a portion of the article or the predefined excerpt text.", 'admin translation')
				),

				'1' => array (
				'name'			=> __('Post excerpt length', 'admin translation'),
				'label'			=> 'post_excerpt_length',
				'validation'	=> 'prevent_empty_number',
				'type'			=> 'text',
				'value'			=> '260',
				'description'	=> __("Is an option to change text length on a post when it's displayed on an archive page, i.e. it shortens the text with the amount entered in the field (null disables the feature).", 'admin translation')
				),

				'2' => array (
				'name'			=> __('Post link option', 'admin translation'),
				'label'			=> 'post_link_option',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> array(__("Use: Read more", "admin translation"), __("Use: Continue reading", "admin translation"), __("Use: See full article", "admin translation"), __("Use: Read this post", "admin translation"), __("Use: Learn more", "admin translation")),
				'description'	=> __("Is an option to change what text to use for the link on a page when it's displayed on an archive page, i.e. either a static text or the alternative text.", 'admin translation')
				),

				'3' => array (
				'name'			=> __('Title excerpt length', 'admin translation'),
				'label'			=> 'title_excerpt_length',
				'validation'	=> 'prevent_empty_number',
				'type'			=> 'text',
				'value'			=> '76',
				'description'	=> __("Is an option to change text length on a post when it's displayed on an archive page, i.e. it shortens the text with the amount entered in the field (null disables the feature).", 'admin translation')
				)
			),
			
			__('Related posts', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Post history', 'admin translation'),
				'label'			=> 'post_history',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> array(array(__('2 weeks old', 'admin translation'), '2 week ago'), array(__('4 weeks old', 'admin translation'), '30 days ago'), array(__('8 weeks old', 'admin translation'), '8 week ago'), array(__('3 month old', 'admin translation'), '8 week ago'), array(__('6 month old', 'admin translation'), '180 days ago')),
				'description'	=> __('Is an option to change how far back in history the related posts on a blog article should fetch articles. Note that it fetches all articles within this date period and randomize the output, and only 3 articles will be visible.', 'admin translation')
				)
			),
			
			__('Widget areas', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Sidebar builder', 'admin translation'),
				'label'			=> 'custom_sidebars',
				'validation'	=> '',
				'type'			=> 'input list',
				'value'			=> '',
				'button'		=> __('Create sidebar', 'admin translation'),
				'description'	=> __('Is an option to create new widget areas, which later can be used on a blog article under a specific category. <br><br>Type a name that will be used for your new widget area, like "product articles". <br><br>Please note that a sidebar which is created here, must be selected and saved for a blog category to work. ', 'admin translation')
				)
			)
		)
	);
	
	new Register($setup);
?>