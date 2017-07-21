<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	namespace MetaBoxOptions;

	// Sets up a new page with custom theme settings
	//
	// slug 		= The slug name used in the ID attribute of the meta box (should be a unique variable name)
	// title 		= The title of the meta box
	// screen 		= The screen or content type on which to show the box (such as a post type, 'page', 'post', 'showcase', 'link', 'comment', etc)
	// context 		= The context within the screen where the boxes should display (contexts include 'normal', 'side' and 'advanced')
	// priority 	= The priority within the context where the boxes should show ('default', 'high' or 'low')
	//
	// See detailed meta box settings description here: https://developer.wordpress.org/reference/functions/add_meta_box/
	
	$setup = array (

		'slug'			=> 'post_options',
		'title'			=> __('Post Settings', 'admin translation'),
		'screen'		=> 'post',
		'context'		=> 'normal',
		'priority'		=> 'high',
		'options'		=> array (

			__('SEO', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Additional title', 'admin translation'),
				'label'			=> 'additional_title',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __('Is an option for adding an extra page title to ensure the site have an unique title on every page. Please note that this option needs to be activated under layout settings.', 'admin translation')
				),
				
				'1' => array (
				'name'			=> __('Meta description', 'admin translation'),
				'label'			=> 'meta_description',
				'validation'	=> '',
				'maximum'		=> '150',
				'rows'			=> '4',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> __('The meta description is used to specify the description of the page and is recommended not be longer than 150 characters.', 'admin translation')
				),

				'2' => array (
				'name'			=> __('Meta keywords', 'admin translation'),
				'label'			=> 'meta_keywords',
				'validation'	=> 'verify_meta_keywords',
				'keycount'		=> '10',
				'rows'			=> '2',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> sprintf(__('The meta keywords are used to specify keywords used in the text of the page and is recommended not be more than 10-15 unique words (use comma separated list). %s Please note that keywords are not longer used by many of the major search engines and therefore has less importance.', 'admin translation'), '<br><br>')
				),
				
				'3' => array (
				'name'			=> __('Meta author', 'admin translation'),
				'label'			=> 'meta_author',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __('Is an option to define the author of this page, i.e. it will reference the name of the person who created the document for the page being viewed.', 'admin translation')
				),
				
				'4' => array (
				'name'			=> __('SEO preview', 'admin translation'),
				'label'			=> 'seo_preview',
				'validation'	=> '',
				'type'			=> 'seo preview',
				'value'			=> '',
				'settings'		=> array(array('title', 'title'), array('expanded', 'additional_title'), array('format', 'page_title_format'), array('separator', 'page_title_separator'), array('description', 'meta_description')),
				'description'	=> __('This is a preview on how the search result of this page can look like on a Google search results page or a results page on any other search engine provider.', 'admin translation')
				),

				'5' => array (
				'name'			=> __('Sitemap', 'admin translation'),
				'label'			=> 'generate_sitemap',
				'validation'	=> 'generate_xml_sitemap',
				'type'			=> 'hidden',
				'value'			=> '',
				'target'		=> array('seo_options', 'generate_sitemap'),
				'description'	=> __('This field will regenerate a new sitemap in the background each time a page or post is published.', 'admin translation')
				)
			),

			__('Open Graph', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Facebook title', 'admin translation'),
				'label'			=> 'facebook_title',
				'validation'	=> '',
				'maximum'		=> '48',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This field is used for the title of the website when it's shared on social media and should be kept under 48 characters.", 'admin translation')
				),

				'1' => array (
				'name'			=> __('Facebook description', 'admin translation'),
				'label'			=> 'facebook_description',
				'validation'	=> '',
				'maximum'		=> '130',
				'rows'			=> '4',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> __("This field is used for the description of the website when it's shared on social media and the readable text should be kept under 130 characters.", 'admin translation')
				),

				'2' => array (
				'name'			=> __('Facebook media', 'admin translation'),
				'label'			=> 'facebook_media',
				'validation'	=> '',
				'type'			=> 'media',
				'rendering'		=> 'single',
				'description'	=> __("This field is used for the article image when it's shared on social media and the image should be at least 1200px in width, and at least 540px in height. Image must be less than 1MB in size.", 'admin translation')
				),
				
				'3' => array (
				'name'			=> __('Twitter title', 'admin translation'),
				'label'			=> 'twitter_title',
				'validation'	=> '',
				'maximum'		=> '48',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __("This field is used for the title of the website when it's shared on twitter and should be kept under 48 characters.", 'admin translation')
				),

				'4' => array (
				'name'			=> __('Twitter description', 'admin translation'),
				'label'			=> 'twitter_description',
				'validation'	=> '',
				'maximum'		=> '130',
				'rows'			=> '4',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> __("This field is used for the description of the website when it's shared on twitter and the readable text should be kept under 130 characters.", 'admin translation')
				),

				'5' => array (
				'name'			=> __('Twitter media', 'admin translation'),
				'label'			=> 'twitter_media',
				'validation'	=> '',
				'type'			=> 'media',
				'rendering'		=> 'single',
				'description'	=> __("This field is used for the article image when it's shared on social media and the image should be at least 1200px in width, and at least 540px in height. Image must be less than 1MB in size.", 'admin translation')
				)
			),

			__('Meta', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Block search engines', 'admin translation'),
				'label'			=> 'meta_robots',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> array(__('Hide this page', 'admin translation'), __('Show this page', 'admin translation')),
				'description'	=> __('Is an option to prevent this page to be indexed in search engines.', 'admin translation')
				),
				
				'1' => array (
				'name'			=> __('Sitemap priority', 'admin translation'),
				'label'			=> 'sitemap_priority',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> array(array('1.0', '1.0'), array('0.9', '0.9'), array('0.8', '0.8'), array('0.7', '0.7'), array('0.6', '0.6'), array('0.5', '0.5'), array('0.4', '0.4'), array('0.3', '0.3'), array('0.2', '0.2'), array('0.1', '0.1')),
				'description'	=> __('Is an option to change the priority of this page in your xml sitemap for search engines. Default value is 0.8 or less, based on hierarchy.', 'admin translation')
				),
				
				'2' => array (
				'name'			=> __('Canonical URL', 'admin translation'),
				'label'			=> 'canonical_url',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> sprintf(__('Is an option to define a canonical URL of this page, i.e. if there is a similar page with the same content. Paste the URL of the page you would like to refer to instead of this one. Read more about %s.', 'admin translation'), '<a href="http://www.seomoz.org/blog/canonical-url-tag-the-most-important-advancement-in-seo-practices-since-sitemaps/" target="_blank">'.__('canonical URL:s', 'admin translation').'</a>')
				),
				
				'3' => array (
				'name'			=> __('301 Redirect', 'admin translation'),
				'label'			=> 'redirect_url',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> sprintf(__('Is an option to redirect this page to another, i.e. to send both users and search engines to a different URL than the one they originally requested. Paste the URL of the page you would like to redirect to. Read more about %s.', 'admin translation'), '<a href="http://www.seomoz.org/learn-seo/redirection/" target="_blank">'.__('redirection', 'admin translation').'</a>')
				),

				'4' => array (
				'name'			=> __('Reading time', 'admin translation'),
				'label'			=> 'reading_time',
				'validation'	=> 'set_article_reading_time',
				'type'			=> 'hidden',
				'value'			=> '',
				'description'	=> __('This field will count the length of the article and evaluate how long time it will take to read.', 'admin translation')
				),
			),

			__('Sidebar', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Active sidebar', 'admin translation'),
				'label'			=> 'active_sidebar',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> get_theme_option('blog_options', 'custom_sidebars'),
				'description'	=> sprintf(__('Is an option to add a custom sidebar for this page, i.e. this page will display the widgets that are added to the custom sidebar, which has been selected above. <br><br>You can use the sidebar builder %s, to build your own sidebars. If left empty, the primary sidebar will be used.', 'admin translation'), '<a href="'.get_admin_url().'admin.php?page=blog_options#widget-areas" target="_blank">'.__('here', 'admin translation').'</a>')
				)
			)
		)
	);
	
	new Register($setup);
?>