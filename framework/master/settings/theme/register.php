<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;

	// Register new theme options

	class Register {
		
		private	$slug;
		private	$options;

		public function __construct($options) {

			$this->options = $options;

			add_action('init', array($this, 'init'));
    		add_action('admin_init', array($this, 'admin_init'));
    		add_action('admin_menu', array($this, 'admin_menu'));
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
		
			add_option($this->slug, '', '', 'yes');
			add_option($this->slug.'_fields', '', '', 'yes');
			update_option($this->slug.'_fields', $this->options['options']);
		}

		/**
		 * Registers a hook into wp admin menu
		 *
		 */

		public function admin_menu() {

			if (is_array($this->options) && count($this->options) >= 8 && $this->options['slug'] !== '') {

				if ($this->options['parent'] === '') {

					add_menu_page($this->options['title'], $this->options['name'], $this->options['capability'], $this->options['slug'], array($this, 'setup_menu_page'), $this->options['icon'], $this->options['position']);
				}
				else {

					add_submenu_page($this->options['parent'], $this->options['title'], $this->options['name'], $this->options['capability'], $this->options['slug'], array($this, 'setup_menu_page'));
				}
			}
		}

		/**
		 * Defines default values and calls the build class
		 *
		 */

		public function setup_menu_page() {

			$build = new Build($this->slug, $this->options);
			$build->build_menu_page();
		}
		
	}
?>