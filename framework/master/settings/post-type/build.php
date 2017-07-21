<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace PostTypeOptions;
	use ThemeOptions as ThemeOptions;

	// Builds new post type options

	class Build {

		private	$slug;
		private	$options;

		public function __construct($slug, $options) {

			$this->slug 	= $slug;
			$this->options 	= $options;

			add_filter('post_updated_messages', array($this, 'update_messages'));
		}

		/**
		 * Register a custom post type
		 *
		 */

		public function register_post_type() {
			
			register_post_type($this->slug, $this->options);
		}

		/**
		 * Register user roles
		 *
		 */

		public function register_roles($capability) {

			$users = is_array($capability) && !empty($capability) ? $capability : array('administrator');

			$plural = str_replace('-', '_', sanitize_title($this->options['labels']['name']));
			$singular = str_replace('-', '_', sanitize_title($this->options['labels']['singular_name']));

			foreach ($users as $i => $user) {
				
				$role = get_role($user);
			
				$role->add_cap('read_'.$singular);
				$role->add_cap('publish_'.$plural);
				$role->add_cap('edit_'.$singular);
				$role->add_cap('edit_'.$plural);
				$role->add_cap('delete_'.$singular);
				$role->add_cap('delete_'.$plural);
				$role->add_cap('edit_published_'.$plural);
				$role->add_cap('delete_published_'.$plural);

				if ($user != 'author') {

					$role->add_cap('edit_others_'.$plural);
					$role->add_cap('delete_others_'.$plural);

					$role->add_cap('edit_private_'.$plural);
					$role->add_cap('read_private_'.$plural);
					$role->add_cap('delete_private_'.$plural);
				}
			}
		}

		/**
		 * Updates feedback messages when a new post type is created
		 *
		 * @param $messages 		- array with strings
		 *
		 * @return array
		 */

		public function update_messages($messages) {
			
			global $post, $post_ID;
		
			$messages[$post->post_type] = array (
			
				0 	=> '',
				1 	=> sprintf(__('%s updated. %s', 'admin translation'), str_replace('_', ' ', ucfirst($post->post_type)), '<a href="'.esc_url(get_permalink($post_ID)).'">'.__('View', 'admin translation').' '.$post->post_type.'</a>'),
				2 	=> __('Custom field updated.', 'admin translation'),
				3 	=> __('Custom field deleted.', 'admin translation'),
				4 	=> sprintf(__('%s updated.', 'admin translation'), str_replace('_', ' ', ucfirst($post->post_type))),
				5 	=> isset($_GET['revision']) ? sprintf( __('%s restored to revision from %s', 'admin translation'), str_replace('_', ' ', ucfirst($post->post_type)), wp_post_revision_title((int) $_GET['revision'], false)) : false,
				6 	=> sprintf(__('%s published. %s', 'admin translation'), str_replace('_', ' ', ucfirst($post->post_type)), '<a href="'.esc_url(get_permalink($post_ID)).'">'.__('View', 'admin translation').' '.$post->post_type.'</a>'),
				7 	=> sprintf(__('%s saved.', 'admin translation'), str_replace('_', ' ', ucfirst($post->post_type))),
				8 	=> sprintf(__('%s submitted. %s', 'admin translation'), str_replace('_', ' ', ucfirst($post->post_type)), '<a target="_blank" href="'.esc_url(add_query_arg('preview', 'true', get_permalink($post_ID))).'">'.__('Preview', 'admin translation').' '.$post->post_type.'</a>'),
				9 	=> sprintf(__('%s scheduled for: %s', 'admin translation'), str_replace('_', ' ', ucfirst($post->post_type)), '<strong>'.date_i18n(__('M j, Y @ G:i', 'admin translation'), strtotime($post->post_date)).'</strong>. <a target="_blank" href="'.esc_url(get_permalink($post_ID)).'">'.__('Preview', 'admin translation').' '.$post->post_type.'</a>'),
				10 	=> sprintf(__('%s draft updated. %s', 'admin translation'), str_replace('_', ' ', ucfirst($post->post_type)), '<a target="_blank" href="'.esc_url(add_query_arg('preview', 'true', get_permalink($post_ID))).'">'.__('Preview', 'admin translation').' '.$post->post_type.'</a>')
			);
		
			return $messages;
		}
		
	}

?>