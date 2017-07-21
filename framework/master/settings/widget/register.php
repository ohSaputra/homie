<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace WidgetOptions;

	// Register new post options

	class Register {

		private	$slug;
		private	$name;
		private	$options;

		public function __construct($options) {

			$this->options 	= $options;
			$this->name 	= self::get_widget_factory_name($this->options['slug']);

			add_action('init', array($this, 'init'));
    		add_action('admin_init', array($this, 'admin_init'));
    		add_action('widgets_init', array($this, 'register_sidebar'));
    		add_action('widgets_init', array($this, 'register_custom_sidebars'));
    		add_action('widgets_init', array($this, 'register_widget'));
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
			$this->slug = strtolower('widget_'.THEME_NAME.'_'.$name);
		
			add_option($this->slug.'_fields', '', '', 'yes');
			update_option($this->slug.'_fields', $this->options['options']);
		}

		/**
		 * Registers custom widgets and initializes the build constructor
		 *
		 */

		public function register_widget() {

			global $wp_widget_factory;

			$wp_widget_factory->widgets[$this->name] = new Build($this->options);
		}

		/**
		 * Returns a widget factory name
		 *
		 * @param $slug 	- string database name
		 *
		 * @return string
		 */

		public static function get_widget_factory_name($slug) {
			
			$string = strtoupper(THEME_NAME).'_'.str_replace(' ', '_', ucwords($slug));

			return $string;
		}

		/**
		 * Register support for widgets and sidebars
		 *
		 */

		public function register_sidebar() {

			register_sidebar(array(
				
				'id' 			=> 'post-widgets',
				'name'			=> __('Main Sidebar (blog)', 'admin translation'),
				'description' 	=> __('Appears on all blog post pages.', 'admin translation'),
				'before_widget' => "\n".'<!-- widget starts -->'."\n"."\t".'<div class="widget post-widget %2$s">'."\n",
				'before_title' 	=> "\t\t".'<div class="widget-header"><h4>',
				'after_title' 	=> '</h4></div>'."\n",
				'after_widget' 	=> "\t".'</div>'."\n".'<!-- widget ends -->'."\n\n"
			));
			
			register_sidebar(array(
					
				'id' 			=> 'page-widgets',
				'name'			=> __('Main Sidebar (pages)', 'admin translation'),
				'description' 	=> __('Appears on all standard content pages.', 'admin translation'),
				'before_widget' => "\n".'<!-- widget starts -->'."\n"."\t".'<div class="widget post-widget %2$s">'."\n",
				'before_title' 	=> "\t\t".'<div class="widget-header"><h4>',
				'after_title' 	=> '</h4></div>'."\n",
				'after_widget' 	=> "\t".'</div>'."\n".'<!-- widget ends -->'."\n\n"
			));
		}

		/**
		 * Register support for custom sidebars added with sidebar builder
		 *
		 */

		public function register_custom_sidebars() {

			$sidebars = get_theme_option('blog_options', 'custom_sidebars');

			if (is_array($sidebars) && !empty($sidebars)) {

				foreach ($sidebars as $id => $sidebar) {

					register_sidebar(array(
					
						'id' 			=> sanitize_title($sidebar),
						'name'			=> sprintf(__('Main Sidebar (%s)', 'admin translation'), strtolower($sidebar)),
						'description' 	=> sprintf(__('The primary widget area for %s pages.', 'admin translation'), strtolower($sidebar)),
						'before_widget' => "\n".'<!-- widget starts -->'."\n"."\t".'<div class="widget post-widget %2$s">'."\n",
						'before_title' 	=> "\t\t".'<div class="widget-header"><h4>',
						'after_title' 	=> '</h4></div>'."\n",
						'after_widget' 	=> "\t".'</div>'."\n".'<!-- widget ends -->'."\n\n"
					));
				}
			}
		}
	}
?>