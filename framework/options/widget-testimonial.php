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

		'slug'			=> 'testimonial',
		'title'			=> __('Testimonial', 'admin translation'),
		'description' 	=> __('Displays a testimonial widget', 'admin translation'),
		'class'			=> 'widget-testimonial',
		'options'		=> array (
			
			'0' => array (
			'name'			=> __('Media', 'admin translation'),
			'label'			=> 'media',
			'validation'	=> '',
			'type'			=> 'media'
			),
			
			'1' => array (
			'name'			=> __('Testimonial', 'admin translation'),
			'label'			=> 'testimonial',
			'validation'	=> '',
			'maximum'		=> '',
			'rows'			=> '8',
			'type'			=> 'textarea',
			'value'			=> ''
			),

			'2' => array (
			'name'			=> __('Name', 'admin translation'),
			'label'			=> 'name',
			'validation'	=> '',
			'type'			=> 'text',
			'value'			=> ''
			),

			'3' => array (
			'name'			=> __('Job title', 'admin translation'),
			'label'			=> 'job_title',
			'validation'	=> '',
			'type'			=> 'text',
			'value'			=> ''
			),
		)
	);
	
	new Register($setup);
?>