<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	/**
	 * Returns all categories from the media library
	 *
	 * @return array
	 */
	
	if (! function_exists('get_all_listed_categories')) :

		function get_all_listed_categories($arguments = array()) {
			
			$category = array();

			$defaults = array('type' => 'post', 'taxonomy' => 'category', 'visible' => true, 'orderby' => 'name', 'order' => 'ASC');
			$settings = wp_parse_args($arguments, $defaults);

			$result = get_categories(array( 'type' => $settings['type'], 'taxonomy' => $settings['taxonomy'], 'orderby' => $settings['orderby'], 'hide_empty' => $settings['visible'], 'order' => $settings['order'] ));

			foreach ($result as $key => $media) {
				
				$category[$key]['id'] = $media->term_id;
				$category[$key]['title'] = $media->name;
				$category[$key]['parent'] = $media->parent;
				$category[$key]['url'] = get_category_link($media->term_id);
			}
			
			return $category;
		}

	endif;

	/**
	 * Returns all custom post types from the media library
	 *
	 * @return array
	 */

	if (! function_exists('get_all_listed_post_types')) :
	
		function get_all_listed_post_types($arguments = array()) {
			
			$types = array();

			$defaults = array('type' => 'showcase', 'status' => 'publish', 'max' => -1, 'orderby' => 'menu_order', 'order' => 'ASC');
			$settings = wp_parse_args($arguments, $defaults);
			
			$result = new WP_Query(array( 'post_type' => $settings['type'], 'post_status' => $settings['status'], 'posts_per_page' => $settings['max'], 'orderby' => $settings['orderby'], 'order' => $settings['order'] ));
			
			foreach ($result->posts as $key => $media) {
				
				$types[$key]['id'] = $media->ID;
				$types[$key]['title'] = $media->post_title;
				$types[$key]['order'] = $media->menu_order;
				$types[$key]['url'] = get_permalink($media->ID);
			}
			
			return $types;
		}

	endif;

	/**
	 * Returns all published pages from the media library
	 *
	 * @return array
	 */

	if (! function_exists('get_all_published_pages')) :
			
		function get_all_published_pages($arguments = array()) {
			
			$pages = array();

			$defaults = array('type' => 'page', 'status' => 'publish', 'max' => -1, 'orderby' => 'title', 'order' => 'ASC', 'exclude' => array('template-modal.php', 'template-404.php'));
			$settings = wp_parse_args($arguments, $defaults);
			
			foreach ($settings['exclude'] as $key => $template) {

				$exclude = get_all_template_page_id(array('template' => $template));
			}

			$settings['exclude'] = array_merge($exclude);

			$result = new WP_Query(array( 'post_type' => $settings['type'], 'post__not_in' => $settings['exclude'], 'post_status' => $settings['status'], 'posts_per_page' => $settings['max'], 'orderby' => $settings['orderby'], 'order' => $settings['order'] ));
									
			foreach ($result->posts as $key => $media) {
			
				$pages[$key]['id'] = $media->ID;
				$pages[$key]['title'] = $media->post_title;
				$pages[$key]['parent'] = $media->post_parent;
				$pages[$key]['url'] = get_permalink($media->ID);
			}
			
			return $pages;
		}

	endif;

	/**
	 * Returns an array with all template pages as ID's
	 *
	 * @return array
	 */

	if (! function_exists('get_all_template_page_id')) :
			
		function get_all_template_page_id($arguments = array()) {
			
			$pages = array();

			$defaults = array('template' => 'template.php');
			$settings = wp_parse_args($arguments, $defaults);

			$result = new WP_Query(array( 'post_type' => 'page', 'meta_query' => array(array('key' => '_wp_page_template', 'value' => $settings['template'])) ));
									
			foreach ($result->posts as $key => $media) {
				
				array_push($pages, $media->ID);
			}
			
			return $pages;
		}

	endif;

	/**
	 * Returns all taxonomies pages from the media library
	 *
	 * @return array
	 */

	if (! function_exists('get_all_published_taxonomies')) :
			
		function get_all_published_taxonomies($arguments = array()) {
			
			global $wpdb;
			
			$pages = array();

			$defaults = array('taxonomy' => 'portfolio', 'visible' => false, 'max' => -1, 'order' => 'ASC');
			$settings = wp_parse_args($arguments, $defaults);

			$result = $wpdb->get_results("SELECT t.*, tt.* FROM ".$wpdb->terms." AS t INNER JOIN ".$wpdb->term_taxonomy." AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ('".$settings['taxonomy']."') ORDER BY t.name ".$settings['order']."", OBJECT);

			foreach ($result as $key => $taxonomy) {
				
				if ($settings['visible'] === true) {

					if ($taxonomy->count >= 1) {

						$pages[$key]['id'] = $taxonomy->term_id;
						$pages[$key]['slug'] = $taxonomy->slug;
						$pages[$key]['title'] = $taxonomy->name;
						$pages[$key]['parent'] = $taxonomy->parent;
						$pages[$key]['url'] = get_category_link($taxonomy->term_id);
						$pages[$key]['count'] = $taxonomy->count;
					}
				}
				else {

					$pages[$key]['id'] = $taxonomy->term_id;
					$pages[$key]['slug'] = $taxonomy->slug;
					$pages[$key]['title'] = $taxonomy->name;
					$pages[$key]['parent'] = $taxonomy->parent;
					$pages[$key]['url'] = get_category_link($taxonomy->term_id);
					$pages[$key]['count'] = $taxonomy->count;
				}
			}
			
			return $pages;
		}

	endif;

	/**
	 * Returns all registered sidebars
	 *
	 * @return array
	 */
	
	if (! function_exists('get_all_registered_sidebars')) :
			
		function get_all_registered_sidebars() {
			
			$sidebars = array();
			$exclude = get_theme_option('excluded_widget_areas');
			$i = 0;
			
			foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
				
				if (in_array($sidebar['id'], $exclude) == 0) {
					
					$sidebars[$i][0] = $sidebar['name'];
					$sidebars[$i][1] = $sidebar['id'];
					
					$i++;
				}
			}
			
			return $sidebars;
		}

	endif;

	/**
	 * Returns all template pages from the media library
	 *
	 * @return array
	 */
	
	if (! function_exists('get_all_template_pages')) :
			
		function get_all_template_pages($arguments = array()) {
			
			$pages = array();

			$defaults = array('template' => 'template.php');
			$settings = wp_parse_args($arguments, $defaults);

			$result = new WP_Query(array('post_type' => 'page', 'meta_query' => array(array('key' => '_wp_page_template', 'value' => $settings['template']))));
									
			foreach ($result->posts as $key => $media) {
				
				$pages[$key]['id'] = $media->ID;
				$pages[$key]['title'] = $media->post_title;
				$pages[$key]['parent'] = $media->post_parent;
				$pages[$key]['url'] = get_permalink($media->ID);
			}
			
			return $pages;
		}

	endif;

	/**
	 * Returns all media attachments from the media library
	 *
	 * @param $mime_types 	- array with mimetypes to fetch (application, text, image)
	 *
	 * @return array
	 */
	
	if (! function_exists('get_all_media_attachments')) :
			
		function get_all_media_attachments($arguments = array()) {
			
			$files = array();

			$defaults = array('types' => array(), 'status' => 'inherit', 'max' => -1, 'order' => 'DESC');
			$settings = wp_parse_args($arguments, $defaults);

			$attachments = new WP_Query(array( 'post_type' => 'attachment', 'post_mime_type' => $settings['types'], 'post_status' => $settings['status'], 'posts_per_page' => $settings['max'], 'order' => $settings['order'] ));
									
			foreach ($attachments->posts as $key => $media) {
				
				$filetype = wp_check_filetype($media->guid);

				$files[$key]['id'] = $media->ID;
				$files[$key]['title'] = $media->post_title;
				$files[$key]['mimetype'] = $filetype['ext'];
				$files[$key]['url'] = wp_get_attachment_url($media->ID);
			}
						
			usort($files, 'sort_by_mimetype');
			
			return $files;
		}

	endif;

	/**
	 * Sorts a multiple dimensional array by mimetype
	 *
	 * @return array
	 */
	
	if (! function_exists('sort_by_mimetype')) :
	
		function sort_by_mimetype($a, $b) {
			
			return strcmp($a['mimetype'], $b['mimetype']);
		}

	endif;
	
	/**
	 * Returns an array with the different page title formats
	 *
	 * @return string
	 */

	if (! function_exists('get_page_title_formats')) :

		function get_page_title_formats() {
			
			$content = array(__('Page title - Company name', 'admin translation'), __('Page title - Company name - Additional title', 'admin translation'), __('Page title - Additional title', 'admin translation'), __('Page title - Additional title - Company name', 'admin translation'), __('Company name - Page title', 'admin translation'), __('Company name - Page title - Additional title', 'admin translation'), __('Company name - Additional title', 'admin translation'), __('Company name - Additional title - Page title', 'admin translation'), __('Additional title - Page title', 'admin translation'), __('Additional title - Page title - Company name', 'admin translation'), __('Additional title - Company name', 'admin translation'), __('Additional title - Company name - Page title', 'admin translation'), __('Company name - Tagline', 'admin translation'), __('Company name - Tagline - Page title', 'admin translation'), __('Company name - Tagline - Additional title', 'admin translation'), __('Only Company name', 'admin translation'), __('Only Page title', 'admin translation'), __('Only Additional title', 'admin translation'));
			
			return $content;
		}

	endif;
	
	/**
	 * Returns an array with the different page title separators
	 *
	 * @return string
	 */
	
	if (! function_exists('get_page_title_separator')) :

		function get_page_title_separator() {
			
			$content = array(__("' - '", "admin translation"), __("' | '", "admin translation"), __("', '", "admin translation"), __("' > '", "admin translation"), __("Only a space between", "admin translation"));
			
			return $content;
		}

	endif;
		
	/**
	 * Returns the facebook open graph protocol options
	 *
	 * @return array
	 */
	
	if (! function_exists('get_open_graph_protocol')) :

		function get_open_graph_protocol() {
			
			$protocol = array(
			array("optgroup" => __('Activities', 'admin translation'), "options" => array(__('activity', 'admin translation'), __('sport', 'admin translation'))), 
			array("optgroup" => __('Businesses', 'admin translation'), "options" => array(__('bar', 'admin translation'), __('company', 'admin translation'), __('cafe', 'admin translation'), __('hotel', 'admin translation'), __('restaurant', 'admin translation'))), 
			array("optgroup" => __('Groups', 'admin translation'), "options" => array(__('cause', 'admin translation'), __('sports league', 'admin translation'), __('sports team', 'admin translation'))), 
			array("optgroup" => __('Organizations', 'admin translation'), "options" => array(__('band', 'admin translation'), __('government', 'admin translation'), __('non profit', 'admin translation'), __('school', 'admin translation'), __('university', 'admin translation'))), 
			array("optgroup" => __('People', 'admin translation'), "options" => array(__('actor', 'admin translation'), __('athlete', 'admin translation'), __('author', 'admin translation'), __('director', 'admin translation'), __('musician', 'admin translation'), __('politician', 'admin translation'), __('public figure', 'admin translation'))), 
			array("optgroup" => __('Places', 'admin translation'), "options" => array(__('city', 'admin translation'), __('country', 'admin translation'), __('landmark', 'admin translation'), __('state province', 'admin translation'))), 
			array("optgroup" => __('Products and Entertainment', 'admin translation'), "options" => array(__('album', 'admin translation'), __('book', 'admin translation'), __('drink', 'admin translation'), __('food', 'admin translation'), __('game', 'admin translation'), __('product', 'admin translation'), __('song', 'admin translation'), __('movie', 'admin translation'), __('tv show', 'admin translation'))), 
			array("optgroup" => __('Websites', 'admin translation'), "options" => array(__('blog', 'admin translation'), __('website', 'admin translation'), __('article', 'admin translation'))));

			return $protocol;
		}

	endif;

	/**
	 * Returns microdata open hour options
	 *
	 * @return array
	 */
	
	if (! function_exists('get_microdata_opening_hours')) :

		function get_microdata_opening_hours() {
			
			$itemprop = array(
			array('00:00', '00:00'),
			array('01:00', '01:00'),
			array('02:00', '02:00'),
			array('03:00', '03:00'),
			array('04:00', '04:00'),
			array('05:00', '05:00'),
			array('06:00', '06:00'),
			array('07:00', '07:00'),
			array('08:00', '08:00'),
			array('09:00', '09:00'),
			array('10:00', '10:00'), 
			array('11:00', '11:00'),
			array('12:00', '12:00'),
			array('13:00', '13:00'),
			array('14:00', '14:00'),
			array('15:00', '15:00'),
			array('16:00', '16:00'),
			array('17:00', '17:00'),
			array('18:00', '18:00'),
			array('19:00', '19:00'),
			array('20:00', '20:00'),
			array('21:00', '21:00'),
			array('22:00', '22:00'),
			array('23:00', '23:00'));

			return $itemprop;
		}

	endif;

	/**
	 * Returns microdata contact options
	 *
	 * @return array
	 */
	
	if (! function_exists('get_microdata_contact_options')) :

		function get_microdata_contact_options() {
			
			$itemprop = array(
			array('Customer Service', 'Customer Service'),
			array('Technical Support', 'Technical Support'),
			array('Billing Support', 'Billing Support'),
			array('Bill Payment', 'Bill Payment'),
			array('Sales', 'Sales'),
			array('Reservations', 'Reservations'),
			array('Credit Card Support', 'Credit Card Support'),
			array('Emergency', 'Emergency'),
			array('Baggage Tracking', 'Baggage Tracking'),
			array('Roadside Assistance', 'Roadside Assistance'),
			array('Package Tracking', 'Package Tracking'));

			return $itemprop;
		}

	endif;

	/**
	 * Returns an array of taxonomy options
	 *
	 * @return array
	 */
	
	if (! function_exists('get_taxonomy_options')) :

		function get_taxonomy_options($arguments = array()) {
			
			$options = array();

			$defaults = array('taxonomy' => 'tag', 'visible' => false, 'id' => 'slug');
			$settings = wp_parse_args($arguments, $defaults);

			$taxonomies = get_all_published_taxonomies(array('taxonomy' => $settings['taxonomy'], 'visible' => $settings['visible']));

			if (is_array($taxonomies) && count($taxonomies) >= 1) {

		    	foreach ($taxonomies as $key => $taxonomy) {
		    		
		    		array_push($options, array($taxonomy['title'], $taxonomy[$settings['id']]));
		    	}
		    }

			return $options;
		}
	
	endif;

	/**
	 * Returns all pages, posts and all links from the media library
	 *
	 * @return array
	 */
	
	if (! function_exists('get_all_listed_content')) :

		function get_all_listed_content($arguments = array()) {
		
			$content = array();

			$defaults = array('types' => array('link', 'page', 'tag', 'category', 'post'), 'order' => 'ASC', 'exclude' => array('template-modal.php', 'template-404.php'));
			$settings = wp_parse_args($arguments, $defaults);
			
			foreach ($settings['types'] as $type) {
				
				$temp = array();
				
				if ($type == 'link') {
					
					$temp = array(array('optgroup' => __('- Choose a bookmark', 'admin translation'), 'options' => array()));
					
					$result = get_bookmarks(array( 'category_name' => '', 'orderby' => 'name', 'order' => $settings['order'] ));
						
					foreach ($result as $key => $media) {
						
						$temp[0]['options'][$key]['id'] = $type.', '.$media->link_id;
						$temp[0]['options'][$key]['title'] = $media->link_name;
						$temp[0]['options'][$key]['url'] = $media->link_url;
						$temp[0]['options'][$key]['rss'] = $media->link_rss;
					}
					
					$content = empty($temp[0]['options']) ? $content : array_merge($content, $temp);
				}
				else if ($type == 'tag') {

					$temp = array(array('optgroup' => __('- Choose a tag', 'admin translation'), 'options' => array()));

					$result = get_tags();

					foreach ($result as $key => $media) {

						$temp[0]['options'][$key]['id'] = $type.', '.$media->term_id;
						$temp[0]['options'][$key]['title'] = $media->name;
						$temp[0]['options'][$key]['parent'] = $media->parent;
						$temp[0]['options'][$key]['url'] = get_tag_link($media->term_id);
					}

					$content = empty($temp[0]['options']) ? $content : array_merge($content, $temp);
				}
				else if ($type == 'category') {
					
					$temp = array(array('optgroup' => __('- Choose a category', 'admin translation'), 'options' => array()));
					
					$result = get_categories(array( 'type' => 'post', 'taxonomy' => 'category', 'orderby' => 'name', 'order' => $settings['order'] ));
					
					foreach ($result as $key => $media) {
						
						$temp[0]['options'][$key]['id'] = $type.', '.$media->term_id;
						$temp[0]['options'][$key]['title'] = $media->name;
						$temp[0]['options'][$key]['parent'] = $media->parent;
						$temp[0]['options'][$key]['url'] = get_category_link($media->term_id);
					}
					
					$content = empty($temp[0]['options']) ? $content : array_merge($content, $temp);
				}
				else {
					
					$temp = array(array('optgroup' => sprintf(__('- Choose a %s', 'admin translation'), $type), 'options' => array()));
					
					foreach ($settings['exclude'] as $key => $template) {

						$exclude = get_all_template_page_id(array('template' => $template));
					}

					$settings['exclude'] = array_merge($exclude);
			
					$result = new WP_Query(array( 'post_type' => $type, 'post_status' => 'publish', 'post__not_in' => $settings['exclude'], 'posts_per_page' => -1, 'orderby' => 'title', 'order' => $settings['order'] ));
						
					foreach ($result->posts as $key => $media) {
																
						$temp[0]['options'][$key]['id'] = $type.', '.$media->ID;
						$temp[0]['options'][$key]['title'] = $media->post_title;
						$temp[0]['options'][$key]['parent'] = $media->post_parent;
						$temp[0]['options'][$key]['url'] = get_permalink($media->ID);
					}
					
					$content = empty($temp[0]['options']) ? $content : array_merge($content, $temp);
				}
			}
			
			return $content;
		}

	endif;
	
?>