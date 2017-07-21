<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace PostTypeTaxonomy;

	// Register new post type options

	class Register {

		private	$slug;
		private	$screen;
		private	$capability;
		private	$options;

		public function __construct($options) {

			$this->slug 		= $options['slug'];
			$this->screen 		= $options['screen'];
			$this->capability 	= isset($options['capability']) ? $options['capability'] : '';
			$this->options 		= $options;

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
				
				'name' 							=> $options['name'],
				'singular_name' 				=> $options['singular'],
				'search_items' 					=> sprintf(__('Search %s', 'admin translation'), $options['name']),
				'popular_items' 				=> sprintf(__('Popular %s', 'admin translation'), $options['name']),
				'all_items' 					=> sprintf(__('All %s', 'admin translation'), $options['name']),
				'parent_item' 					=> sprintf(__('Parent %s', 'admin translation'), $options['singular']),
				'parent_item_colon' 			=> sprintf(__('Parent %s', 'admin translation'), $options['singular']),
				'edit_item' 					=> sprintf(__('Edit %s', 'admin translation'), $options['singular']),
				'update_item' 					=> sprintf(__('Update %s', 'admin translation'), $options['singular']),
				'add_new_item' 					=> sprintf(__('Add New %s', 'admin translation'), $options['singular']),
				'new_item_name' 				=> sprintf(__('New %s', 'admin translation'), $options['singular']),
				'separate_items_with_commas'	=> __('Separate tags with commas', 'admin translation'),
				'add_or_remove_items' 			=> __('Add or remove tags', 'admin translation'),
				'choose_from_most_used' 		=> __('Choose from the most used tags', 'admin translation'),
				'menu_name' 					=> $options['name']
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

			$capabilities = array (

			    'manage_terms' 				=> 'manage_'.$plural,
			    'edit_terms' 				=> 'edit_'.$plural,
			    'delete_terms' 				=> 'delete_'.$plural,
			    'assign_terms' 				=> 'assign_'.$plural,
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

				'label' 					=> $options['singular'],
				'labels' 					=> $labels,
				'public' 					=> $options['public'],
				'show_in_nav_menus'			=> $options['menuitem'],
				'show_ui'					=> true,
				'show_tagcloud'				=> $options['tagcloud'],
				'hierarchical' 				=> $options['hierarchical'],
				'update_count_callback'		=> false,
				'query_var' 				=> true,
				'rewrite' 					=> array('slug' => $options['slug']),
				'capability_type' 			=> $options['slug'],
				'capabilities'				=> $capabilities,
			);
			
			return $arguments;
		}

		/**
		 * Register user roles
		 *
		 */

		public function register_roles($capability) {

			$users = is_array($capability) && !empty($capability) ? $capability : array('administrator');
			$plural = str_replace('-', '_', sanitize_title($this->options['name']));

			foreach ($users as $i => $user) {
				
				$role = get_role($user);
			
				$role->add_cap('manage_'.$plural);
				$role->add_cap('edit_'.$plural);
				$role->add_cap('delete_'.$plural);
				$role->add_cap('assign_'.$plural);
			}
		}

		/**
		 * Registers each custom post type to the theme
		 *
		 * @param $options 		- custom post type options
		 */

		public function register_post_type($options) {

			if (is_array($options) && count($options) >= 1) {

				foreach ($options as $term => $arguments) {

					register_taxonomy($term, $this->screen, $arguments);
					self::register_roles($this->capability);
				}
			}
		}
	}

?>