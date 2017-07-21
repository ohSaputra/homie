<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace UserOptions;

	// Register new user options

	class Register {

		private	$slug;
		private	$options;

		public function __construct($options) {

			$this->options 	= $options;

			add_action('init', array($this, 'init'));
    		add_action('admin_init', array($this, 'admin_init'));

    		add_action('show_user_profile', array($this, 'build'));
			add_action('edit_user_profile', array($this, 'build'));
			add_action('personal_options_update', array($this, 'save'));
			add_action('edit_user_profile_update', array($this, 'save'));
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
		 * Defines default values and calls the build class
		 *
		 * @param $user 	- object to access the slug of the user itself
		 *
		 */

		public function build($user) {		

			$build = new Build($user, $this->slug, $this->options);
			$build->add_options();
		}

		/**
		 * Validates and saves the user values into the database
		 *
		 * @param $id 		- id of current user
		 *
		 */

		public function save($id) {

			if (current_user_can('edit_user', $id)) {
				
				$options = get_option($this->slug.'_fields');

				foreach ($options as $label => $fields) {

					foreach ($fields as $field) {

						Save::save_options($this->slug, $field, $id);
					}
				}
			}
		}
	}

?>