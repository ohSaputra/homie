<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace TaxonomyOptions;

	// Register new taxonomy options

	class Register {

		private	$slug;
		private	$options;
		private	$screen;

		public function __construct($options) {

			$this->options 	= $options;
			$this->screen 	= $options['screen'];

			add_action('init', array($this, 'init'));
    		add_action('admin_init', array($this, 'admin_init'));

			add_action('create_'.$this->screen, array($this, 'save_taxonomy'));
			add_action('edited_'.$this->screen, array($this, 'save_taxonomy'));
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

			add_action($this->screen.'_add_form_fields', array($this, 'add_taxonomy'));
			add_action($this->screen.'_term_new_form_tag', array($this, 'set_form_multipart'));

			add_action($this->screen.'_edit_form_fields', array($this, 'edit_taxonomy'));
			add_action($this->screen.'_term_edit_form_tag', array($this, 'set_form_multipart'));
		}

		/**
		 * Append enctype multipart/form-data and encoding multipart/form-data on form element
		 *
		 * @param $id 		- id of current page or post
		 *
		 */
		
		public function set_form_multipart($term) {

			printf(' enctype="multipart/form-data" encoding="multipart/form-data" ');
		}

		/**
		 * Defines default values and calls the build class
		 *
		 * @param $term 	- object to access the slug of the term itself
		 *
		 */

		public function add_taxonomy($term) {			

			$build = new Build($term, $this->slug, $this->options);
			$build->add_taxonomy();
		}

		/**
		 * Defines editable values and calls the build class
		 *
		 * @param $term 	- object to access the slug of the term itself
		 *
		 */

		public function edit_taxonomy($term) {

			$build = new Build($term, $this->slug, $this->options);
			$build->edit_taxonomy();
		}

		/**
		 * Validates and saves the taxonomy values into the database
		 *
		 * @param $id 		- id of current taxonomy
		 *
		 */

		public function save_taxonomy($id) {
			
			$options = get_option($this->slug.'_fields');

			foreach ($options as $label => $fields) {
						
				foreach ($fields as $field) {
					
					Save::save_term($this->slug, $field, $id);
				}
			}
		}
	}

?>