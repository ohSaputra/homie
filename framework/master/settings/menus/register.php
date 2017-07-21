<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace MenuOptions;

	// Register new taxonomy options

	class Register {

		private	$slug;
		private	$options;

		public function __construct($options) {

			$this->options 	= $options;

			add_action('init', array($this, 'init'));
    		add_action('admin_init', array($this, 'admin_init'));
    		add_action('admin_init', array($this, 'register'));
		}

		/**
		 * Registers a hook into wp init
		 *
		 */

		public function init() {


		}

		/**
		 * Registers a hook into wp admin init
		 *
		 */

		public function admin_init() {
			
			$name = $this->options['slug'];
			$this->slug = strtolower(THEME_NAME.'_'.$name);
		
			add_option($this->slug.'_fields', '', '', 'yes');
			update_option($this->slug.'_fields', $this->options['options']);
		}

		/**
		 * Register custom menu options
		 *
		 */

		public function register() {
			
			$menus['auto_add'] = array();
			$options = get_option($this->slug.'_fields');

			if (is_array($options) && count($options) >= 1) {

				foreach ($options as $menu => $option) {

					register_nav_menu($option['name'], $option['class']);

					if (! is_nav_menu($option['name'])) {

						$id = wp_create_nav_menu($option['name']);
						
						self::populate($id, $option['items']);
						self::location($id, $option['name']);
						
						if ($option['auto'] === true) { array_push($menus['auto_add'], $id); }
					}
				}

				self::options($menus);
			}
		}

		/**
		 * Updates custom menu options
		 *
		 */

		public function options($menus) {

			if (count($menus['auto_add']) >= 1) { 

				update_option('nav_menu_options', $menus);
			}
		}

		/**
		 * Updates custom menu locations
		 *
		 * @param $id 			- string menu id
		 * @param $location 	- string menu location slug name
		 *
		 */

		public function location($id, $location) {
			
			$locations = get_theme_mod('nav_menu_locations');

			if (is_array($locations) && count($locations) >= 1) {

				$locations = array_merge($locations, array($location => $id));
				set_theme_mod('nav_menu_locations', $locations);
			}
			else {

				set_theme_mod('nav_menu_locations', array($location => $id));
			}
		}

		/**
		 * Adds custom menu items to the menu structure
		 *
		 * @param $id 			- string menu id
		 * @param $items 		- array with menu items
		 *
		 */

		public function populate($id, $items) {

			if (is_array($items) && count($items) >= 1) {

				foreach ($items as $menu => $link) {

					wp_update_nav_menu_item($id, 0, $link);
				}
			}
		}
	}

?>