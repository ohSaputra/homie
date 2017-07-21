<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	namespace TaxonomyOptions;

	// Sets up custom taxonomy options
	//
	// slug 		= The slug name used in the ID attribute of category options (should be a unique variable name)
	// title 		= The title of category options
	// screen 		= The screen or content type on which to show taxonomy options (such as a taxonomy type, 'category', 'showcase', 'movies', 'articles', etc)
	//
	// See detailed taxonomy settings description here: https://codex.wordpress.org/Function_Reference/register_taxonomy
	
	$setup = array (

		'slug'			=> 'category_options',
		'title'			=> __('Category Settings', 'admin translation'),
		'screen'		=> 'category',
		'options'		=> array (

			__('Meta data', 'admin translation') => array (

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
				
				'4' => array (
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
				'description'	=> sprintf(__('The meta keywords are used to specify keywords used in the text of the page and is recommended not be more than 10-15 unique words (use comma separated list). %s Please note that keywords are not longer used by many of the major search engines and therefore has less importance.', 'admin translation'), '<br><br>')
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
				),	
			)
		)
	);
	
	new Register($setup);
?>