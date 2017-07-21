<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace MetaBoxOptions;

	// Register new post options

	class Register {

		private	$slug;
		private	$options;
		private	$screen;

		public function __construct($options) {

			$this->options 	= $options;
			$this->screen 	= $options['screen'];

			add_action('init', array($this, 'init'));
    		add_action('admin_init', array($this, 'admin_init'));
		}

		/**
		 * Registers a hook into wp init
		 *
		 */

		public function init() {

			add_action('save_post', array($this, 'save_post'), 10, 1);
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

			add_action('post_edit_form_tag', array($this, 'set_form_multipart'), 10, 1);
			add_action('add_meta_boxes'.'_'.$this->screen, array($this, 'register_meta_box'));
		}
		
		/**
		 * Register a custom meta box
		 *
		 */

		public function register_meta_box() {

			add_meta_box($this->slug, $this->options['title'], array($this, 'setup_meta_box'), $this->screen, $this->options['context'], $this->options['priority']);
			remove_meta_box('postcustom', $this->screen, 'normal');
		}

		/**
		 * Defines default values and calls the build class
		 *
		 */

		public function setup_meta_box($post) {
			
			$build = new Build($post->ID, $this->slug, $this->options);
			$build->build_meta_box();
		}

		/**
		 * Append enctype multipart/form-data and encoding multipart/form-data on form element
		 *
		 * @param $id 		- id of current page or post
		 *
		 */
		
		public function set_form_multipart($post) {

			if (isset($post->ID) && $this->screen == get_post_type($post->ID)) {

				printf(' enctype="multipart/form-data" encoding="multipart/form-data" ');
			}
		}

		/**
		 * Registers a hook into wp save post
		 *
		 * @param $id 		- id of current page or post
		 *
		 */

		public function save_post($id) {

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        	
        		return;
			}

			if (! isset($_POST[$this->slug.'_noncename']) || ! wp_verify_nonce($_POST[$this->slug.'_noncename'], dirname(__FILE__)) || ! check_admin_referer(dirname(__FILE__), $this->slug.'_noncename')) {

				return;
			}

			if (isset($_POST['post_type']) && $_POST['post_type'] == $this->screen && current_user_can('edit_post', $id)) {

				Save::save_meta_options($this->slug, $this->options['options'], $id);
			}
			else {

				return;
			}
		}

	}
?>