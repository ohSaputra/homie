<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	namespace WidgetOptions;

	// Sets up a new page with custom theme settings
	//
	// slug 		= The slug name used in the ID attribute of widget (should be a unique variable name)
	// title 		= The text to be displayed in the title tags of the widget
	// description 	= The text to be displayed in the description field of the widget
	// class		= The class name used on the widget and which also will be used for its PHP template, i.e. widget-feature.php
		
	$setup = array (

		'slug'			=> 'html_content',
		'title'			=> __('Custom HTML content', 'admin translation'),
		'description' 	=> __('Displays HTML code in a widget', 'admin translation'),
		'class'			=> 'widget-html-content',
		'options'		=> array (
			
			'0' => array (
			'name'			=> __('Title', 'admin translation'),
			'label'			=> 'title',
			'validation'	=> '',
			'type'			=> 'text',
			'value'			=> ''
			),
			
			'1' => array (
			'name'			=> __('HTML code', 'admin translation'),
			'label'			=> 'html_code',
			'validation'	=> '',
			'maximum'		=> '',
			'rows'			=> '8',
			'type'			=> 'textarea',
			'value'			=> ''
			),
			
			'2' => array (
			'name'			=> __('Layout', 'admin translation'),
			'label'			=> 'layout',
			'validation'	=> '',
			'type'			=> 'select',
			'value'			=> '',
			'options'		=> array(__('Use only HTML', 'admin translation'), __('Use whole Widget', 'admin translation'))
			)
		)
	);
	
	new Register($setup);
?>