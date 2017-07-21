<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace PostTypeOptions;

	// Register new post type options

	class Register {

		private	$slug;
		private	$options;
		private	$capability;

		public function __construct($options) {

			$this->options 		= $options;
			$this->slug 		= $options['slug'];
			$this->capability 	= isset($options['capability']) ? $options['capability'] : '';

			add_action('init', array($this, 'init'));
    		add_action('admin_init', array($this, 'admin_init'));
		}

		/**
		 * Registers a hook into wp init
		 *
		 */

		public function init() {

			$labels = self::set_labels($this->options);
			$capabilities = self::set_capabilities($this->options);
			$arguments = self::set_arguments($this->options, $labels, $capabilities);

			$options = array($this->slug => $arguments);

			self::register_post_type($options);
		}

		/**
		 * Registers a hook into wp admin init
		 *
		 */

		public function admin_init() {
			
		}

		/**
		 * Defines the custom post type labels
		 *
		 * @param $options 		- custom post type options
		 *
		 * @return array
		 */

		public function set_labels($options) {

			$labels = array (
			
				'name' 						=> $options['name'],
				'singular_name' 			=> $options['singular'],
				'menu_name'					=> $options['name'],
				'all_items'					=> $options['name'],
				'add_new' 					=> __('Add New', 'admin translation'),
				'add_new_item' 				=> sprintf(__('Add New %s', 'admin translation'), $options['singular']),
				'edit' 						=> __('Edit', 'admin translation'),
				'edit_item' 				=> sprintf(__('Edit %s', 'admin translation'), $options['singular']),
				'new_item' 					=> sprintf(__('New %s', 'admin translation'), $options['singular']),
				'view' 						=> sprintf(__('View %s', 'admin translation'), $options['singular']),
				'view_item' 				=> sprintf(__('View %s', 'admin translation'), $options['singular']),
				'search_items' 				=> sprintf(__('Search %s', 'admin translation'), $options['name']),
				'not_found' 				=> sprintf(__('No %s found', 'admin translation'), $options['name']),
				'not_found_in_trash'		=> sprintf(__('No %s found in Trash', 'admin translation'), $options['name']),
				'parent_item_colon'			=> sprintf(__('Parent %s', 'admin translation'), $options['singular']),
			);

			return $labels;
		}

		/**
		 * Defines the custom post type capabilities
		 *
		 * @param $options 		- custom post type options
		 *
		 * @return array
		 */

		public function set_capabilities($options) {

			$plural = str_replace('-', '_', sanitize_title($options['name']));
			$singular = str_replace('-', '_', sanitize_title($options['singular']));

			$capabilities = array (
		
				'read'						=> 'read',
				'edit_post'					=> 'edit_'.$singular,
				'edit_posts'				=> 'edit_'.$plural,
				'edit_others_posts'			=> 'edit_others_'.$plural,
				'edit_private_posts'		=> 'edit_private_'.$plural,
				'edit_published_posts'		=> 'edit_published_'.$plural,
				'publish_posts'				=> 'publish_'.$plural,
				'read_post'					=> 'read_'.$singular,
				'read_private_posts'		=> 'read_private_'.$plural,
				'delete_post'				=> 'delete_'.$singular,
				'delete_posts'				=> 'delete_'.$plural,
				'delete_others_posts'		=> 'delete_others_'.$plural,
				'delete_private_posts'		=> 'delete_private_'.$plural,
				'delete_published_posts'	=> 'delete_published_'.$plural,
			);

			return $capabilities;
		}

		/**
		 * Defines the custom post type arguments
		 *
		 * @param $options 		- custom post type options
		 * @param $labels 		- custom post type labels
		 * @param $capabilities - custom post type capabilities
		 *
		 * @return array
		 */

		public function set_arguments($options, $labels, $capabilities) {
			
			$arguments = array (

				'slug' 						=> $options['slug'],
				'label' 					=> $options['singular'],
				'labels' 					=> $labels,
				'description' 				=> $options['description'],
				'public' 					=> $options['public'],
				'exclude_from_search' 		=> $options['searchable'] === false ? true : false,
				'publicly_queryable' 		=> true,
				'show_ui' 					=> true,
				'show_in_nav_menus'			=> $options['menuitem'],
				'show_in_menu'				=> $options['admin'],
				'show_in_admin_bar'			=> true,
				'menu_position' 			=> $options['position'],
				'menu_icon'					=> $options['icon'] === '' ? 'dashicons-admin-post' : $options['icon'],
				'capability_type' 			=> $options['slug'],
				'capabilities'				=> $capabilities,
				'map_meta_cap'				=> true,
				'hierarchical' 				=> $options['hierarchical'],
				'register_meta_box_cb'		=> '',
				'has_archive'				=> false,
				'rewrite' 					=> $options['permalink'] === false ? array('slug' => $options['rewrite'] === '' ? '/' : $options['rewrite'], 'with_front' => false) : array('slug' => $options['rewrite'] === '' ? $options['slug'] : $options['rewrite']),
				'query_var' 				=> true,
				'can_export' 				=> true,
				'supports' 					=> $options['supports']
			);
						
			return $arguments;
		}

		/**
		 * Registers each custom post type to the theme
		 *
		 * @param $options 		- custom post type options
		 */

		public function register_post_type($options) {

			if (is_array($options) && count($options) >= 1) {

				foreach ($options as $term => $arguments) {

					$build = new Build($term, $arguments);

					$build->register_post_type();
					$build->register_roles($this->capability);
				}
			}
		}
	}

?>