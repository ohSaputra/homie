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

		'slug'			=> 'newsletter',
		'title'			=> __('Newsletter', 'admin translation'),
		'description' 	=> __('Displays a newsletter signup widget', 'admin translation'),
		'class'			=> 'widget-newsletter',
		'options'		=> array (
			
			'0' => array (
			'name'			=> __('Media', 'admin translation'),
			'label'			=> 'media',
			'validation'	=> '',
			'type'			=> 'media'
			),

			'1' => array (
			'name'			=> __('Title', 'admin translation'),
			'label'			=> 'title',
			'validation'	=> '',
			'type'			=> 'text',
			'value'			=> ''
			),

			'2' => array (
			'name'			=> __('Text', 'admin translation'),
			'label'			=> 'text',
			'validation'	=> '',
			'rows'			=> '4',
			'type'			=> 'textarea',
			'value'			=> ''
			),

			'3' => array (
			'name'			=> __('Label', 'admin translation'),
			'label'			=> 'label',
			'validation'	=> '',
			'type'			=> 'text',
			'value'			=> ''
			),

			'4' => array (
			'name'			=> __('Terms', 'admin translation'),
			'label'			=> 'terms',
			'validation'	=> '',
			'type'			=> 'text',
			'value'			=> ''
			)
		)
	);
	
	new Register($setup);
?>