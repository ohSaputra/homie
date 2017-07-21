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

		'slug'			=> 'popular_posts',
		'title'			=> __('Popular Posts', 'admin translation'),
		'description' 	=> __('Displays the most popular posts from a blog category.', 'admin translation'),
		'class'			=> 'widget-popular-posts',
		'options'		=> array (
			
			'0' => array (
			'name'			=> __('Title', 'admin translation'),
			'label'			=> 'title',
			'validation'	=> '',
			'type'			=> 'text',
			'value'			=> ''
			),

			'1' => array (
			'name'			=> __('Blog category', 'admin translation'),
			'label'			=> 'category',
			'validation'	=> '',
			'rendering'		=> '',
			'type'			=> 'select',
			'value'			=> '',
			'default'		=> __('- Choose a category', 'admin translation'),
			'options' 		=> get_all_listed_categories()
			),

			'2' => array (
			'name'			=> __('Time period', 'admin translation'),
			'label'			=> 'time_period',
			'validation'	=> '',
			'type'			=> 'select',
			'value'			=> '',
			'default'		=> __('- Choose a time period', 'admin translation'),
			'options'		=> array(array('14 days', 14), array('30 days', 30), array('90 days', 90), array('180 days', 180))
			),
			
			'3' => array (
			'name'			=> __('Number of posts to show', 'admin translation'),
			'label'			=> 'list_count',
			'validation'	=> '',
			'type'			=> 'select',
			'value'			=> '',
			'options'		=> array(array('1', 1), array('2', 2), array('3', 3), array('4', 4), array('5', 5), array('10', 10))
			)
		)
	);
	
	new Register($setup);
?>