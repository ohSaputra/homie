<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Add custom styles and features to the WordPress Editor

	class TinyMCE {

		public function __construct() {

			add_filter('mce_buttons_2', array($this, 'add_style_selector'));
			add_filter('mce_buttons_2', array($this, 'remove_color_selector'));
			add_filter('tiny_mce_before_init', array($this, 'add_styles'));
		}

		/**
		 * Adds a style selector
		 *
		 * @param $buttons 	- array with editor buttons
		 *
		 */

		public static function add_style_selector($buttons) {
			
			array_splice($buttons, 1, 0, 'styleselect');
			
			return $buttons;
		}

		/**
		 * Adds style classes to the style selector
		 *
		 * @param $settings 	- array with editor settings
		 *
		 */

		public static function add_styles($settings) {
			
			$style_formats = array(

				array('title' => 'Headings', 'items' => array(

					array('title' => 'Lead', 'selector' => 'p', 'classes' => 'lead')
				)),
				array('title' => 'Font', 'items' => array(

					array('title' => 'Light', 'inline' => 'span', 'classes' => 'font-light'),
					array('title' => 'Regular', 'inline' => 'span', 'classes' => 'font-regular'),
					array('title' => 'Bold', 'inline' => 'span', 'classes' => 'font-bold')					
				)),
				array('title' => 'Colors', 'items' => array(
					
					array('title' => 'Blue', 'inline' => 'span', 'classes' => 'text-info'),
					array('title' => 'Green', 'inline' => 'span', 'classes' => 'text-positive'),
					array('title' => 'Grey Dark', 'inline' => 'span', 'classes' => 'text-title'),
					array('title' => 'Grey Default', 'inline' => 'span', 'classes' => 'text-default'),
					array('title' => 'Grey Medium', 'inline' => 'span', 'classes' => 'text-medium'),
					array('title' => 'Grey Light', 'inline' => 'span', 'classes' => 'text-light'),
					array('title' => 'Orange', 'inline' => 'span', 'classes' => 'text-neutral'),
					array('title' => 'Red', 'inline' => 'span', 'classes' => 'text-negative')			
				)),
				array('title' => 'Links', 'items' => array(

					array('title' => 'Button', 'selector' => 'a', 'classes' => 'btn btn-default btn-round btn-lg'),
					array('title' => 'Button primary', 'selector' => 'a', 'classes' => 'btn btn-primary btn-round btn-lg'),
					array('title' => 'Button secondary', 'selector' => 'a', 'classes' => 'btn btn-secondary btn-round btn-lg'),
					array('title' => 'Ghost button', 'selector' => 'a', 'classes' => 'btn btn-ghost-default btn-round btn-lg'),
					array('title' => 'Ghost button primary', 'selector' => 'a', 'classes' => 'btn btn-ghost-primary btn-round btn-lg'),
					array('title' => 'Ghost button secondary', 'selector' => 'a', 'classes' => 'btn btn-ghost-secondary btn-round btn-lg'),
					array('title' => 'Link', 'selector' => 'a', 'classes' => 'link decoration')
				)),
				array('title' => 'Lists', 'items' => array(
					
					array('title' => 'Plus list', 'selector' => 'ul', 'classes' => 'tick-list plus-list'),
					array('title' => 'Minus list', 'selector' => 'ul', 'classes' => 'tick-list minus-list'),
					array('title' => 'Tick list', 'selector' => 'ul', 'classes' => 'tick-list'),
					array('title' => 'Unstyled list', 'selector' => 'ul', 'classes' => 'list-unstyled'),
					array('title' => '2 Column list', 'selector' => 'ul', 'classes' => 'column-list'),
					array('title' => '3 Column list', 'selector' => 'ul', 'classes' => 'column-list columns-03'),
					array('title' => '4 Column list', 'selector' => 'ul', 'classes' => 'column-list columns-04'),
				)),
				array('title' => 'Divider', 'items' => array(

					array('title' => 'Separator', 'block' => 'hr', 'classes' => 'separator'),
					array('title' => 'Standard divider', 'block' => 'hr'),
					array('title' => 'Dotted divider', 'block' => 'hr', 'classes' => 'dashed'),
					array('title' => 'Dashed divider', 'block' => 'hr', 'classes' => 'dotted')
				)),
				array('title' => 'Misc', 'items' => array(

					array('title' => 'Preformatted text', 'block' => 'pre'),
					array('title' => 'Code element', 'inline' => 'code'),
					array('title' => 'Mark element', 'inline' => 'mark'),
					array('title' => 'Sub element', 'inline' => 'sub'),
					array('title' => 'Sup element', 'inline' => 'sup')
				))
			);

			$formats = array(

				'alignleft' => array(

					array('selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', 'classes' => 'text-left'),
					array('selector' => 'img,table,dl.wp-caption', 'classes' => 'text-left'),
				),
				'aligncenter' => array(

					array('selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', 'classes' => 'text-center'),
					array('selector' => 'img,table,dl.wp-caption', 'classes' => 'text-center'),
				),
				'alignright' => array(

					array('selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', 'classes' => 'text-right'),
					array('selector' => 'img,table,dl.wp-caption', 'classes' => 'text-right'),
				),
				'strikethrough' => array(

					array('inline' => 'del')
				),
				'blockquote' => array(

					array('block' => 'blockquote', 'classes' => 'blockquote')
				)
			);

			$settings['formats'] = json_encode($formats);
			$settings['style_formats'] = json_encode($style_formats);

			return $settings;
		}

		/**
		 * Removes the color selector
		 *
		 * @param $buttons 	- array with editor buttons
		 *
		 */

		public static function remove_color_selector($buttons) {
			
			$remove = 'forecolor';

			if (($key = array_search($remove, $buttons)) !== false) { unset($buttons[$key]); }
			
			return $buttons;
		}
	}

	new TinyMCE();
?>