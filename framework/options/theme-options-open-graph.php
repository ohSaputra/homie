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

		'slug'			=> 'open_graph_options',
		'name'			=> __('Open Graph', 'admin translation'),
		'title'			=> __('Open Graph options', 'admin translation'),
		'capability'	=> 'update_themes',
		'icon'			=> 'dashicons-desktop',
		'parent'		=> 'layout_options',
		'position'		=> 104,
		'options'		 => array (

			__('Facebook', 'admin translation') => array (
				
				'0' => array (
				'name'			=> __('Facebook ID', 'admin translation'),
				'label'			=> 'facebook_id',
				'validation'	=> 'validate_facebook_id',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This field is used for social media sharing and to connect this website's blog posts to a Facebook App ID. Type our 15 digit facebook ID.", 'admin translation')
				),

				'1' => array (
				'name'			=> __('Facebook name', 'admin translation'),
				'label'			=> 'facebook_website_name',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This field is used for social media sharing and to connect this website's blog posts to a website name. Please type our website name.", 'admin translation')
				),

				'2' => array (
				'name'			=> __('Facebook title', 'admin translation'),
				'label'			=> 'facebook_title',
				'validation'	=> '',
				'maximum'		=> '48',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This field is used for the title of the website when it's shared on social media and should be kept under 48 characters.", 'admin translation')
				),

				'3' => array (
				'name'			=> __('Facebook description', 'admin translation'),
				'label'			=> 'facebook_description',
				'validation'	=> '',
				'maximum'		=> '130',
				'rows'			=> '4',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> __("This field is used for the description of the website when it's shared on social media and the readable text should be kept under 130 characters.", 'admin translation')
				),

				'4' => array (
				'name'			=> __('Facebook media', 'admin translation'),
				'label'			=> 'facebook_media',
				'validation'	=> '',
				'type'			=> 'media',
				'rendering'		=> 'single',
				'description'	=> __("This field is used for the article image when it's shared on social media and the image should be at least 1200px in width, and at least 540px in height. Image must be less than 1MB in size.", 'admin translation')
				)
			),

			__('Twitter', 'admin translation') => array (
				
				'0' => array (
				'name'			=> __('Twitter username', 'admin translation'),
				'label'			=> 'twitter_username',
				'validation'	=> 'validate_twitter_username',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This field is used for social media sharing and to connect this website's blog posts to a Twitter username.", 'admin translation')
				),

				'1' => array (
				'name'			=> __('Twitter title', 'admin translation'),
				'label'			=> 'twitter_title',
				'validation'	=> '',
				'maximum'		=> '48',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This field is used for the title of the website when it's shared on twitter and should be kept under 48 characters.", 'admin translation')
				),

				'2' => array (
				'name'			=> __('Twitter description', 'admin translation'),
				'label'			=> 'twitter_description',
				'validation'	=> '',
				'maximum'		=> '130',
				'rows'			=> '4',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> __("This field is used for the description of the website when it's shared on twitter and the readable text should be kept under 130 characters.", 'admin translation')
				),

				'3' => array (
				'name'			=> __('Twitter media', 'admin translation'),
				'label'			=> 'twitter_media',
				'validation'	=> '',
				'type'			=> 'media',
				'rendering'		=> 'single',
				'description'	=> __("This field is used for the article image when it's shared on social media and the image should be at least 1200px in width, and at least 540px in height. Image must be less than 1MB in size.", 'admin translation')
				)
			),
			
			__('Open Graph', 'admin translation') => array (

				'0' => array (
					'name'			=> __('Protocol', 'admin translation'),
					'label'			=> 'open_graph_protocol',
					'validation'	=> '',
					'rendering'		=> '',
					'type'			=> 'select',
					'value'			=> '',
					'options' 		=> get_open_graph_protocol(),
					'description'	=> sprintf(__("Is an option to set the Facebook %s for the content of this website. Default value is set to be a website article.", "admin translation"), '<a href="http://developers.facebook.com/docs/opengraph/" target="_blank">Open Graph protocol</a>')
				)
			),

			__('Social Connect', 'admin translation') => array (
				
				'0' => array (
				'name'			=> __('Facebook URL', 'admin translation'),
				'label'			=> 'facebook_url',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This field is used for social media connect buttons and should link to your public Facebook account. Please type your public Facebook URL.", 'admin translation')
				),

				'1' => array (
				'name'			=> __('Twitter URL', 'admin translation'),
				'label'			=> 'twitter_url',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This field is used for social media connect buttons and should link to your public Twitter account. Please type your public Twitter URL.", 'admin translation')
				),

				'2' => array (
				'name'			=> __('LinkedIn URL', 'admin translation'),
				'label'			=> 'linkedin_url',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This field is used for social media connect buttons and should link to your public LinkedIn account. Please type your public LinkedIn URL.", 'admin translation')
				),

				'3' => array (
				'name'			=> __('Google+ URL', 'admin translation'),
				'label'			=> 'google_url',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This field is used for google+ sharing and to connect this website's blog posts to a Google+ account. Please type our Google+ account URL.", 'admin translation')
				),

				'4' => array (
				'name'			=> __('RSS URL', 'admin translation'),
				'label'			=> 'rss_url',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This field is used for your RSS feed, so that a user can subscribe on your blog posts. Please type your public RSS feed URL.", 'admin translation')
				),
			)
		)
	);

	new Register($setup);
?>