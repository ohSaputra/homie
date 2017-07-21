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

		'slug'			=> 'microdata_options',
		'name'			=> __('Microdata', 'admin translation'),
		'title'			=> __('Microdata options', 'admin translation'),
		'capability'	=> 'update_themes',
		'icon'			=> 'dashicons-desktop',
		'parent'		=> 'layout_options',
		'position'		=> 103,
		'options'		 => array (

			__('Contact', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Phone number (local)', 'admin translation'),
				'label'			=> 'phone_number',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __('Is an option to add a phone number in the header and footer of the website.', 'admin translation')
				),

				'1' => array (
				'name'			=> __('Open hours', 'admin translation'),
				'label'			=> 'open_hours',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> __('Is an option to add a open hours in the header and footer of the website, i.e. Monday - Friday 9:00 am - 6:00 pm.', 'admin translation')
				),
			),

			__('Address', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Postal address', 'admin translation'),
				'label'			=> 'postal_address',
				'validation'	=> '',
				'maximum'		=> '',
				'rows'			=> '3',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> __('Is an option to add a full postal address in the footer of the website.', 'admin translation')
				),
			),

			__('Terms', 'admin translation') => array (
				
				'0' => array (
				'name'			=> __('Copyright text', 'admin translation'),
				'label'			=> 'copyright_text',
				'validation'	=> '',
				'maximum'		=> '',
				'rows'			=> '8',
				'type'			=> 'textarea',
				'value'			=> '',
				'description'	=> __('Is an option to add a copyright text in the footer of the website.', 'admin translation')
				),
			),

			__('Corporate Contact', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Phone number (international)', 'admin translation'),
				'label'			=> 'itemprop_phone_number',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> sprintf(__("Is an option to add a phone number on the website's search attributes. Requires an internationalized version of the phone number, starting with the '+' symbol and country code (+1 in the US and Canada). %sSee more about microdata at %sGoogle Structured Data%s", "admin translation"), '<br><br>', '<a href="https://developers.google.com/search/docs/data-types/local-businesses" target="_blank">', '</a>')
				),

				'1' => array (
				'name'			=> __('Contact Type', 'admin translation'),
				'label'			=> 'itemprop_contact_type',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> get_microdata_contact_options(),
				'description'	=> sprintf(__("Is an option to add a contact type on the website's search attributes. %sSee more about microdata at %sGoogle Structured Data%s", "admin translation"), '<br><br>', '<a href="https://developers.google.com/search/docs/data-types/local-businesses" target="_blank">', '</a>')
				),

				'2' => array (
				'name'			=> __('Opens', 'admin translation'),
				'label'			=> 'itemprop_opens',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> get_microdata_opening_hours(),
				'description'	=> sprintf(__("Is an option to add a open hours to the contact type on the website's search attributes. %sSee more about microdata at %sGoogle Structured Data%s", "admin translation"), '<br><br>', '<a href="https://developers.google.com/search/docs/data-types/local-businesses" target="_blank">', '</a>')
				),
				
				'3' => array (
				'name'			=> __('Closes', 'admin translation'),
				'label'			=> 'itemprop_closes',
				'validation'	=> '',
				'rendering'		=> '',
				'type'			=> 'select',
				'value'			=> '',
				'options' 		=> get_microdata_opening_hours(),
				'description'	=> sprintf(__("Is an option to add a open hours to the contact type on the website's search attributes. %sSee more about microdata at %sGoogle Structured Data%s", "admin translation"), '<br><br>', '<a href="https://developers.google.com/search/docs/data-types/local-businesses" target="_blank">', '</a>')
				),

				'4' => array (
				'name'			=> __('Day of Week', 'admin translation'),
				'label'			=> 'itemprop_day_of_week',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> 'Monday to Friday',
				'description'	=> sprintf(__("Is an option to add what day of the week the service is open on the website's search attributes. Supports single weekdays (Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday) or a combination (Monday to Friday). %sSee more about microdata at %sGoogle Structured Data%s", "admin translation"), '<br><br>', '<a href="https://developers.google.com/search/docs/data-types/local-businesses" target="_blank">', '</a>')
				),
			),

			__('Corporate Address', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Street address', 'admin translation'),
				'label'			=> 'itemprop_street_address',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> sprintf(__("Is an option to add a street address on the website's search attributes. Should be street number, street name, and unit number (if applicable). %sSee more about microdata at %sGoogle Structured Data%s", "admin translation"), '<br><br>', '<a href="https://developers.google.com/search/docs/data-types/local-businesses" target="_blank">', '</a>')
				),

				'1' => array (
				'name'			=> __('City', 'admin translation'),
				'label'			=> 'itemprop_city',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> sprintf(__("Is an option to add a city or a city area on the website's search attributes. %sSee more about microdata at %sGoogle Structured Data%s", "admin translation"), '<br><br>', '<a href="https://developers.google.com/search/docs/data-types/local-businesses" target="_blank">', '</a>')
				),

				'2' => array (
				'name'			=> __('Postal code', 'admin translation'),
				'label'			=> 'itemprop_postal_code',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> sprintf(__("Is an option to add a postal code on the website's search attributes. %sSee more about microdata at %sGoogle Structured Data%s", "admin translation"), '<br><br>', '<a href="https://developers.google.com/search/docs/data-types/local-businesses" target="_blank">', '</a>')
				),

				'3' => array (
				'name'			=> __('State or province', 'admin translation'),
				'label'			=> 'itemprop_state',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> sprintf(__("Is an option to add a state, region or province on the website's search attributes. %sSee more about microdata at %sGoogle Structured Data%s", "admin translation"), '<br><br>', '<a href="https://developers.google.com/search/docs/data-types/local-businesses" target="_blank">', '</a>')
				),

				'4' => array (
				'name'			=> __('Country', 'admin translation'),
				'label'			=> 'itemprop_country',
				'validation'	=> '',
				'type'			=> 'text',
				'value'			=> '',
				'description'	=> sprintf(__("Is an option to add a country on the website's search attributes. %sSee more about microdata at %sGoogle Structured Data%s", "admin translation"), '<br><br>', '<a href="https://developers.google.com/search/docs/data-types/local-businesses" target="_blank">', '</a>')
				),
			),

			__('Map', 'admin translation') => array (

				'0' => array (
				'name'			=> __('Geo Coordinates', 'admin translation'),
				'label'			=> 'itemprop_geo_coordinates',
				'validation'	=> '',
				'type'			=> 'gmap',
				'value'			=> array('latitude' => '-5.878332109674315', 'longitude' => '106.962890625', 'zoom' => '3'),
				'description'	=> sprintf(__("Is an option to add geographic coordinates on the website's search attributes. %sSee more about microdata at %sGoogle Structured Data%s", "admin translation"), '<br><br>', '<a href="https://developers.google.com/search/docs/data-types/local-businesses" target="_blank">', '</a>')
				),
			),
		)
	);
	
	new Register($setup);
?>