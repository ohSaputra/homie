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

		'slug'			=> 'seo_options',
		'name'			=> __('SEO', 'admin translation'),
		'title'			=> __('SEO options', 'admin translation'),
		'capability'	=> 'update_themes',
		'icon'			=> 'dashicons-desktop',
		'parent'		=> 'layout_options',
		'position'		=> 105,
		'options'		 => array (

			__('Meta data', 'admin translation') => array (
				
				'0' => array (
				'name'			=> __('Front page title', 'admin translation'),
				'label'			=> 'title',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __('Is an option for adding an front page title to ensure the site have an unique title on every page.', 'admin translation')
				),
				
				'1' => array (
				'name'			=> __('Additional title', 'admin translation'),
				'label'			=> 'additional_title',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __('Is an option for adding an extra page title to ensure the site have an unique title on every page.', 'admin translation')
				),
				
				'2' => array (
				'name'			=> __('Page title format', 'admin translation'),
				'label'			=> 'page_title_format',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> get_page_title_formats(),
				'description'	=> __('Is an option for changing the formatting of the page title. Default value is the Company name followed by the Tagline.', 'admin translation')
				),
				
				'3' => array (
				'name'			=> __('Page title separator', 'admin translation'),
				'label'			=> 'page_title_separator',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> get_page_title_separator(),
				'description'	=> __('Is an option to change the separator between the title elements. Default value is a dash with spaces.', 'admin translation')
				),
				
				'4' => array (
				'name'			=> __('Meta description', 'admin translation'),
				'label'			=> 'meta_description',
				'validation'	=> '',
				'maximum'		=> '150',
				'rows'			=> '4',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> __('The meta description is used to specify the description of the page and is recommended not be longer than 150 characters.', 'admin translation')
				),
				
				'5' => array (
				'name'			=> __('SEO preview', 'admin translation'),
				'label'			=> 'seo_preview',
				'validation'	=> '',
				'type'			=> 'seo preview',
				'value'			=> '',
				'settings'		=> array(array('title', 'title'), array('expanded', 'additional_title'), array('format', 'page_title_format'), array('separator', 'page_title_separator'), array('description', 'meta_description')),
				'description'	=> __('This is a preview on how the search result of this page can look like on a Google search results page or a results page on any other search engine provider.', 'admin translation')
				)
			),

			__('Meta options', 'admin translation') => array (
				
				'0' => array (
				'name'			=> __('Meta keywords', 'admin translation'),
				'label'			=> 'meta_keywords',
				'validation'	=> 'verify_meta_keywords',
				'keycount'		=> '10',
				'rows'			=> '3',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> sprintf(__('The meta keywords are used to specify keywords used in the text of the page and is recommended not be more than 10-15 unique words (use comma separated list). %sPlease note that keywords are not longer used by many of the major search engines and therefore has less importance.', 'admin translation'), '<br><br>')
				),
				
				'1' => array (
				'name'			=> __('Meta copyright', 'admin translation'),
				'label'			=> 'meta_copyright',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> sprintf(__('Is an option to add a copyright notice to the website meta information. %sPlease note that the copyright meta tag is no longer supported as a valid HTML tag in HTML5, but you can still use it, if it is important for you to show the copyright information.', 'admin translation'), '<br><br>')
				)
			),
			
			__('Analytics options', 'admin translation') => array (
				
				'0' => array (
				'name'			=> __('Google analytics code', 'admin translation'),
				'label'			=> 'google_analytics_code',
				'validation'	=> 'verify_google_analytics_code',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> sprintf(__("Web property ID for tracking website traffic, it normally starts with 'UA-' and it requires a %sGoogle analytics account%s", "admin translation"), '<a href="http://www.google.com/analytics/" target="_blank">', '</a>')
				),
				
				'1' => array (
				'name'			=> __('Alternative JavaScript', 'admin translation'),
				'label'			=> 'alternative_javascript',
				'validation'	=> 'remove_html_special_chars',
				'maximum'		=> '',
				'rows'			=> '6',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> __('Is an option for adding extra javascript in the bottom of the page, i.e. if the Google analytics tracking is for multiple domains.', 'admin translation')
				)
			),
			
			__('Site Verification', 'admin translation') => array (
				
				'0' => array (
				'name'			=> __('Google site verification code', 'admin translation'),
				'label'			=> 'google_verification_code',
				'validation'	=> 'verify_verification_code',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> sprintf(__('Is an option for verifying our website ownership to improve our search rankings and it requires %sGoogle webmaster tools%s', 'admin translation'), '<a href="http://www.google.com/webmasters/tools/" target="_blank">', '</a>')
				),
				
				'1' => array (
				'name'			=> __('Bing site verification code', 'admin translation'),
				'label'			=> 'bing_verification_code',
				'validation'	=> 'verify_verification_code',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> sprintf(__('Is an option for verifying our website ownership to improve our search rankings and it requires %sBing webmaster tools%s', 'admin translation'), '<a href="http://www.bing.com/toolbox/webmaster/" target="_blank">', '</a>')
				)
			),
			
			__('XML sitemap', 'admin translation') => array (
				
				'0' => array (
				'name'			=> __('Update frequency (website)', 'admin translation'),
				'label'			=> 'website_frequency',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> array(array(__('Always', 'admin translation'), 'always'), array(__('Hourly', 'admin translation'), 'hourly'), array(__('Daily', 'admin translation'), 'daily'), array(__('Weekly', 'admin translation'), 'weekly'), array(__('Monthly', 'admin translation'), 'monthly'), array(__('Yearly', 'admin translation'), 'yearly'), array(__('Never', 'admin translation'), 'never')),
				'description'	=> __('Is an option to change how frequently the website is likely to change, i.e. how often the menu structured is changed. Note that it may not correlate exactly to how often search engines crawl the page.', 'admin translation')
				),

				'1' => array (
				'name'			=> __('Update frequency (category)', 'admin translation'),
				'label'			=> 'category_frequencies',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> array(array(__('Always', 'admin translation'), 'always'), array(__('Hourly', 'admin translation'), 'hourly'), array(__('Daily', 'admin translation'), 'daily'), array(__('Weekly', 'admin translation'), 'weekly'), array(__('Monthly', 'admin translation'), 'monthly'), array(__('Yearly', 'admin translation'), 'yearly'), array(__('Never', 'admin translation'), 'never')),
				'description'	=> __('Is an option to change how frequently the blog categories is likely to change on our website. Note that it may not correlate exactly to how often search engines crawl the page.', 'admin translation')
				),
				
				'2' => array (
				'name'			=> __('Update frequency (pages)', 'admin translation'),
				'label'			=> 'page_frequencies',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> array(array(__('Always', 'admin translation'), 'always'), array(__('Hourly', 'admin translation'), 'hourly'), array(__('Daily', 'admin translation'), 'daily'), array(__('Weekly', 'admin translation'), 'weekly'), array(__('Monthly', 'admin translation'), 'monthly'), array(__('Yearly', 'admin translation'), 'yearly'), array(__('Never', 'admin translation'), 'never')),
				'description'	=> __('Is an option to change how frequently the pages is likely to change on our website. Note that it may not correlate exactly to how often search engines crawl the page.', 'admin translation')
				),

				'3' => array (
				'name'			=> __('Sitemap tree', 'admin translation'),
				'label'			=> 'sitemap_tree',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> array(__('Use menu structure', 'admin translation'), __('Use category strucure', 'admin translation')),
				'description'	=> __('Is an option to change how the sitemap will be generated. <br><br>The menu structure option will only include pages and categories published in the menu structure. The category strucure option will only include blog posts that are published under the post categories, i.e. no pages or custom links.', 'admin translation')
				),
				
				'4' => array (
				'name'			=> __('Included post types', 'admin translation'),
				'label'			=> 'included_post_types',
				'validation'	=> '',
				'type'			=> 'hidden',
				'value'			=> '',
				'target'		=> '',
				'description'	=> __('This field will include custom post types that not necessary is not included in a menu structure.', 'admin translation')
				),

				'5' => array (
				'name'			=> __('Generate sitemap', 'admin translation'),
				'label'			=> 'generate_sitemap',
				'validation'	=> 'generate_xml_sitemap',
				'type'			=> 'trigger button',
				'value'			=> '',
				'feedback'		=> '',
				'description'	=> sprintf(__('Is an option to generate a XML sitemap to inform search engines about pages that are available for crawling. See %sXML sitemaps%s.', 'admin translation'), '<a href="http://www.sitemaps.org/" target="_blank">', '</a>')
				)
			)
		)
	);

	new Register($setup);
?>