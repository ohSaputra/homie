<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Generates form fields from custom theme options

	class Popular {

		public function __construct() {

			add_action('wp_head', array($this, 'track'));
			remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
		}

		/**
		 * Adds a page tracker in the header of a page
		 *
		 * @param $id 	- post or page ID
		 *
		 */

		public static function track($id) {
			
			if (! is_singular()) { return; }
			if (empty($id)) { global $post; $id = $post->ID; }

			self::set($id);
		}

		/**
		 * Registers and updates the pageview number
		 *
		 * @param $id 	- post or page ID
		 *
		 */

		public static function set($id) {
			
			$count = get_post_meta($id, 'post_views', true);

			if ($count === '') {

				delete_post_meta($id, 'post_views');
				add_post_meta($id, 'post_views', '0');
			}
			else {

				$count ++;
				update_post_meta($id, 'post_views', $count);
			}
		}

		/**
		 * Returns the page view number
		 *
		 * @param $id 	- post or page ID
		 *
		 * @return integer
		 *
		 */

		public static function get($id) {

			$count = get_post_meta($id, 'post_views', true);

			if ($count === '') {

				delete_post_meta($id, 'post_views');
				add_post_meta($id, 'post_views', '0');

				$count = 0;
			}

			return $count;
		}

		/**
		 * Returns a list with the most popular posts or pages
		 *
		 * @param $type 		- what type to fetch (page, post or attachment)
		 * @param $period 		- during what time period
		 * @param $count 		- how many to include in the list
		 * @param $category 	- what category to fetch (empty fetches all)
		 *
		 * @return array
		 *
		 */

		public static function query($type = 'post', $period = '14', $count = '', $category = '') {
			
			$count = empty($count) ? -1 : $count;
			$category = empty($category) ? '' : $category;

			switch ($period) {

				case '14':

					$date_query = '2 week ago';

				break;
				case '30':

					$date_query = '30 days ago';

				break;
				case '90':

					$date_query = '90 days ago';

				break;
				case '180':

					$date_query = '180 days ago';

				break;
				default:
				
					$date_query = '';

				break;
			}

			if ($type === 'page' || $type === 'attachment') {

				$category = '';
			}

			$args = array(

				'cat' => $category,
				'post_type' => $type,
				'meta_key' => 'post_views',
				'orderby' => 'meta_value_num',
				'date_query' => array(array('after' => $date_query)),
				'posts_per_page' => $count,
				'order' => 'DESC'
			);

			$query = new \WP_Query($args);

			return $query;
		}		
	}

	new Popular();
?>