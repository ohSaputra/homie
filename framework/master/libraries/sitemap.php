<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Generates a XML sitemap

	class XML_Sitemap {
		
		private $slug;
		private $modified_time;
		private $file_size;
		private $sitemap;
		private $robots;
		private $level;
		private $field;
		private $file;
		private $tree;
		private $unique;
		private $excluded;
		private $included;
		private $menu;
		private $categories;
		private $authors;
		private $tags;
		private $forums;
		private $topics;

		public function __construct($slug, $field, $menu = false) {
			
			$this->slug = $slug;
			$this->modified_time = 0;
			$this->file_size = 0;
			$this->sitemap = '';
			$this->robots = '';
			$this->level = 0;
			$this->field = $field;
			$this->tree = array();
			$this->unique = array();
			$this->excluded = array('template-modal.php');
			$this->included = get_theme_option($slug, 'included_post_types');
			$this->menu = get_theme_option($slug, 'sitemap_tree') === '1' ? true : $menu;
			$this->categories = array();
			$this->authors = array();
			$this->tags = array();
			$this->forums = array();
			$this->topics = array();
		}

		/**
		 * Generates the XML sitemap and returns a file URL
		 *
		 * @return string $html
		 */
		
		public function create() {

			$result = array();

			if ($this->menu === true) {

				// if the sitemap should be based on the menu structure of the website
				
				$locations = get_nav_menu_locations();
				$this->generate_menutree($locations);
			}
			else {

				// if the sitemap should be based published posts and pages

				$query = array('post_type' => 'post', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'date', 'order' => 'DESC', 'post_parent' => null);
				$posts = get_posts($query);

				$this->generate_blogtree($posts);
			}

			if (class_exists('bbPress') && $this->menu === false) {

				// if we have the bbpress plugin installed, we're adding the forums to the sitemap tree		

				$query = array('post_type' => 'forum', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'date', 'order' => 'DESC', );
				$forums = get_posts($query);

				$this->generate_forumtree($forums);
			}
			
			if (is_array($this->included) && count($this->included) >= 1) {

				// if we have custom post types that we want to include in the sitemap

				foreach ($this->included as $key => $include) {

					$query = array('post_type' => $include, 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'date', 'order' => 'DESC', );
					$posts = get_posts($query);

					$this->generate_typestree($posts);
				}
			}

			$this->sitemap .= '<?xml version="1.0" encoding="UTF-8"?>'."\n";
			$this->sitemap .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
			
			$this->sitemap .= "\t".'<url>'."\n";
			$this->sitemap .= "\t\t".'<loc>'.$this->get_urlencode(site_url()).'/</loc>'."\n";
			$this->sitemap .= "\t\t".'<lastmod>'.$this->get_date(date('Y-m-d h:i:s')).'</lastmod>'."\n";
			$this->sitemap .= "\t\t".'<changefreq>'.$this->get_changefreq().'</changefreq>'."\n";
			$this->sitemap .= "\t\t".'<priority>1.0</priority>'."\n";
			$this->sitemap .= "\t".'</url>'."\n";
					
			foreach ($this->tree as $key => $page) {
				
				$this->sitemap .= "\t".'<url>'."\n";
				$this->sitemap .= "\t\t".'<loc>'.$this->get_urlencode($page['url']).'</loc>'."\n";
				$this->sitemap .= "\t\t".'<lastmod>'.$this->get_date($page['modified']).'</lastmod>'."\n";
				$this->sitemap .= "\t\t".'<changefreq>'.$page['changefreq'].'</changefreq>'."\n";
				$this->sitemap .= "\t\t".'<priority>'.$page['priority'].'</priority>'."\n";
				$this->sitemap .= "\t".'</url>'."\n";
			}
			
			$this->sitemap .= '</urlset>';
			
			$assets = is_multisite() ? 'sitemaps/' : '';
			$folder = is_multisite() && !is_dir(ABSPATH.$assets) ? wp_mkdir_p(ABSPATH.$assets) : '';
			
			$sitemap_file = is_multisite() ? 'sitemap-'.rtrim(str_replace(array('http://', 'www.', '/'), array('', '', '.'), site_url()), '.').'.xml' : 'sitemap.xml';
			$robots_file = is_multisite() ? 'robots-'.rtrim(str_replace(array('http://', 'www.', '/'), array('', '', '.'), site_url()), '.').'.txt' : 'robots.txt';
			
			$file = fopen(ABSPATH.$assets.$sitemap_file, 'w');
			fwrite($file, $this->sitemap);
			fclose($file);
						
			if (file_exists(ABSPATH.$assets.$sitemap_file)) {

				$home = get_home_path();
				$robots = get_template_directory().'/robots.txt';

				if (file_exists($robots)) {
					
					$this->robots .= file_get_contents($robots)."\n\n";
					$this->robots .= 'sitemap: '.site_url().'/sitemap.xml';
					
					$file = fopen(ABSPATH.$assets.$robots_file, 'w');
					fwrite($file, $this->robots);
					fclose($file);
				}

				if (is_multisite() && file_exists($home.'.htaccess') && is_writable($home.'.htaccess')) {
					
					$htaccess = file_get_contents($home.'.htaccess');
					
					$htaccess = str_replace('RewriteRule ^sitemap.xml sitemap-%{SERVER_NAME}.xml [L]', '', $htaccess);
					$htaccess = str_replace('RewriteRule ^sitemap.xml.gz sitemap-%{SERVER_NAME}.xml.gz [L]', '', $htaccess);
					$htaccess = str_replace('RewriteRule ^robots.txt robots-%{SERVER_NAME}.txt [L]', '', $htaccess);
					
					$rules = strpos($htaccess, 'RewriteRule ^sitemap.xml') ? '' : 'RewriteRule ^sitemap.xml '.$assets.'sitemap-%{SERVER_NAME}.xml [L]'."\n";
					$rules .= strpos($htaccess, 'RewriteRule ^sitemap.xml.gz') ? '' : 'RewriteRule ^sitemap.xml.gz '.$assets.'sitemap-%{SERVER_NAME}.xml.gz [L]'."\n";
					$rules .= strpos($htaccess, 'RewriteRule ^robots.txt') ? '' : 'RewriteRule ^robots.txt '.$assets.'robots-%{SERVER_NAME}.txt [L]'."\n";
					$rules .= strlen($rules) != 0 ? "\n" : '';
					
					if (strpos($htaccess, '# BEGIN WordPress')) {
						
						$htaccess = substr_replace($htaccess, $rules, strpos($htaccess, '# BEGIN WordPress'), 0);
					}
					else if (strpos($htaccess, '<IfModule mod_rewrite.c>')) {
						
						$htaccess = substr_replace($htaccess, $rules, strpos($htaccess, '<IfModule mod_rewrite.c>'), 0);
					}
					else {
						
						$htaccess .= $rules;
					}
					
					$file = fopen($home.'.htaccess', 'w');
					fwrite($file, $htaccess);
					fclose($file);
				}

				$this->file_size = round(filesize(ABSPATH.$assets.$sitemap_file) / 1024, 2);
				$this->modified_time = filemtime(ABSPATH.$assets.$sitemap_file);
				
				$result['value'] = array('0' => array('name'=> 'sitemap.xml', 'url'=> '/'.$assets.$sitemap_file, 'file' => ABSPATH.$assets.$sitemap_file, 'robots' => ABSPATH.$assets.$robots_file, 'pages'=> (count($this->tree) + 1), 'size'=> filesize(ABSPATH.$assets.$sitemap_file), 'date'=> $this->modified_time));
				$result['error'] = '';
				$result['feedback'] = __('Your sitemap.xml file was successfully created.', 'admin translation');
			}
			else {

				$result['value'] = '';
				$result['error'] = $this->field;
				$result['feedback'] = __('There was an issue writing to your sitemap.xml file. Please try again.', 'admin translation');
			}
			
			return $result;
		}

		/**
		 * Returns a date in the correct format
		 *
		 * @return string
		 */
			
		private function get_date($date) {
			
			if ($date == '') { $date = date('Y-m-d h:i:s'); }
			
			$time = date_parse($date);
			
			return date(DATE_ATOM, mktime($time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year']));
		}
				
		/**
		 * Returns the latest modified date from a category
		 *
		 * @return string
		 */

		private function get_taxonomy_date($posts) {
			
			if (is_array($posts) && count($posts) >= 1) {
				
				$modified = array();
				
				foreach($posts as $key => $post) { array_push($modified, $post->post_modified); }
			
				rsort($modified);
			
				$modified = $modified[0];
			}
			else {
				
				$modified = date('Y-m-d h:i:s');	
			}
			
			return $modified;
		}
			
		/**
		 * Escapes the html characters in the URL to make it compatible with xml
		 *
		 * @return string
		 */

		private function get_urlencode($string) {
			
			$entities = array('%21', '%2A', '%27', '%22', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D', '%3C', '%3E');
			$replacements = array('!', '*', "'", '"', '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '%', '#', '[', ']', '<', '>');

			return str_replace($entities, $replacements, urlencode($string));
		}

		/**
		 * Returns the refresh rate value for the website
		 *
		 * @return string
		 */
		
		private function get_changefreq() {
			
			$rate = get_theme_option($this->slug, 'website_frequency');
			
			$frequency = empty($rate) ? 'monthly' : $rate;
			
			return $frequency;
		}

		/**
		 * the refresh rate for a page, depending on settings
		 *
		 * @return string
		 */
		
		private function get_page_changefreq($id, $type) {
						
			if ($type == 'taxonomy') {
				
				$frequency = get_term_meta($id, 'page_frequencies', true);
				$rate = empty($frequency) ? get_theme_option($this->slug, 'category_frequencies') : $frequency;
			} 
			else { 
				
				$frequency = get_post_meta($id, 'page_frequencies', true);
				$rate = empty($frequency) ? get_theme_option($this->slug, 'page_frequencies') : $frequency;
			}
				
			$frequency = empty($rate) ? 'monthly' : $rate;
			
			return $frequency;
		}

		/**
		 * Returns the suitable priority level, depending on settings and hierarchy
		 *
		 * @return string
		 */
		
		private function get_priority($ranking, $level, $type) {
			
			if (!empty($ranking)) {
				
				$priority = $ranking;
			}
			else {
				
				$priority = 0.8;
				$subtract = 0.16;
				
				if ($type == 'taxonomy') { $priority = 0.80; }
				if ($type == 'post') { $priority = 0.64; }
				if ($type == 'tag') { $priority = 0.64; }
				if ($type == 'author') { $priority = 0.64; }
				if ($type == 'forum') { $priority = 0.48; $subtract = 0.8; }
				if ($type == 'forum topic') { $priority = 0.32; $subtract = 0.8; }
				if ($type == 'forum tag') { $priority = 0.16; $subtract = 0.4; }

				if ($level >= 1) { $priority = $priority - ($subtract * $level); }
			}
			
			return max(0, $priority);
		}
				
		/**
		 * Updates the array with the finished sitemap
		 *
		 * @param $id 			- page id
		 * @param $modified 	- modified date
		 * @param $url 			- page url
		 * @param $comments 	- comment count
		 * @param $type 		- page type
		 * @param $level 		- page hierarchy in menu
		 * @param $changefreq 	- refresh rate
		 * @param $priority 	- page priority
		 * @param $exclude 		- if page should be exluded
		 *
		 */

		private function update_tree($id, $modified, $url, $comments, $type, $level, $changefreq, $priority, $exclude) {
			
			if (! array_search($id.', '.$url, $this->unique) && $exclude != '1') {
			
				array_push($this->tree, array(
					
					'id'		=>	$id, 
					'modified'	=>	$modified, 
					'url'		=>	$url, 
					'comments'	=>	$comments,
					'type'		=>	$type,
					'level' 	=>	$level,
					'changefreq' =>	$changefreq,
					'priority'	=>	$priority
				));
				
				array_push($this->unique, $id.', '.$url);
			}
		}

		/**
		 * Updates and returns a unique array with categories
		 *
		 * @param $categories 	- array with post category ids
		 */
		
		private function update_categories($categories) {
			
			foreach ($categories as $id => $key) {

				in_array($key, $this->categories) != 1 ? array_push($this->categories, $key) : '';
			}
		}

		/**
		 * Updates and returns a unique array with tags
		 *
		 * @param $tags 	- array with post tag ids
		 */
		
		private function update_tags($tags) {

			foreach ($tags as $id => $key) {

				in_array($key->term_id, $this->tags) != 1 ? array_push($this->tags, $key->term_id) : '';
			}
		}

		/**
		 * Updates and returns a unique array with authors
		 *
		 * @param $author 	- string id of an author
		 */
		
		private function update_authors($author) {
			
			in_array($author, $this->authors) != 1 ? array_push($this->authors, $author) : '';
		}

		/**
		 * Updates and returns a unique array with forums
		 *
		 * @param $forum 	- string id of a forum
		 */
		
		private function update_forums($forum) {
			
			in_array($forum, $this->forums) != 1 ? array_push($this->forums, $forum) : '';
		}

		/**
		 * Updates and returns a unique array with forum topic tags
		 *
		 * @param $tags 	- array with forum topic tag ids
		 */
		
		private function update_topic_tags($tags) {

			foreach ($tags as $id => $key) {

				in_array($key->term_id, $this->topics) != 1 ? array_push($this->topics, $key->term_id) : '';
			}
		}

		/**
		 * Returns the hierarchy level of the current page
		 *
		 * @param $items 	- array with menu items
		 * @param $parent 	- parent page
		 * @param $level 	- depth of menu items
		 */
		
		private function get_parent_level($items, $parent, $level) {

			$level ++;
			$counter = 0;

			foreach ($items as $key => $value) {
				
				if ($parent == $value->ID) { $counter = $key; break; }
			}
			
			if ($items[$counter]->menu_item_parent == '0') {
				
				$this->level = $level;
			
				return;
			}
			else {
				
				$this->get_parent_level($items, $items[$counter]->menu_item_parent, $level);
			}
		}		

		/**
		 * Loops through the menu tree and creates an array with sitemap pages
		 *
		 * @param $locations 	- array with menu locations
		 */
		
		private function generate_menutree($locations) {
			
			if (is_array($locations) && count($locations) >= 1) {

				foreach ($locations as $menu => $key) {
				
					$items = wp_get_nav_menu_items($menu, $args = array());
					
					foreach ($items as $key => $page) {

						$data = get_page($page->object_id);
						$exclude = get_post_meta($page->object_id, 'meta_robots', true);
						$template = esc_html(get_post_meta($page->object_id, '_wp_page_template', true));

						if (((isset($data->post_password) && $data->post_password == '') or $page->type == 'taxonomy') && $page->type != 'custom' && in_array($template, $this->excluded) != 1) {

							if ($page->type == 'taxonomy') {
								
								$data = get_term_by('name', $page->title, $page->object);
								$exclude = get_term_meta($data->term_id, 'meta_robots', true);
								
								// fetching the posts published under a taxonomy page
								
								$excludes = array();
								$taxonomy = get_taxonomy($page->object);
								
								if ($taxonomy->object_type[0] != 'post') {
									
									$arguments = array(
										$page->object 	=> $page->title,
										'post_type' 	=> $taxonomy->object_type[0],
										'post_status' 	=> 'publish',
										'numberposts' 	=> -1,
										'exclude' 		=> $excludes,
										'post_parent' 	=> null
									);
								}
								else {
									
									$arguments = array(
										'category' 		=> $page->object_id,
										'post_type' 	=> $taxonomy->object_type[0],
										'post_status' 	=> 'publish',
										'numberposts' 	=> -1,
										'exclude' 		=> $excludes,
										'post_parent' 	=> null
									);	
								}
								
								$posts = get_posts($arguments);
								
								if ($page->menu_item_parent == '0') { $this->level = 0; } else { $this->get_parent_level($items, $page->menu_item_parent, $level = 0); }
								if (get_term_meta($data->term_id, 'sitemap_priority', true)) { $ranking = get_term_meta($data->term_id, 'sitemap_priority', true); } else { $ranking = 0; }
								
								$priority = $this->get_priority($ranking, $this->level, $page->type);
								$changefreq = $this->get_page_changefreq($data->term_id, 'taxonomy');
								
								if ($data->taxonomy == 'post_tag') { $modified = $page->post_modified; } else { $modified = $this->get_taxonomy_date($posts); }
								
								$this->update_tree($data->term_id, $modified, $page->url, $page->comment_count, $page->type, $this->level, $changefreq, $priority, $exclude);
								
								// adding the posts published under a taxonomy page
								
								if (!empty($posts) && $exclude != '1') {
									
									foreach($posts as $key => $post) {
										
										$exclude = get_post_meta($post->ID, 'meta_robots', true);
										
										$priority = $this->get_priority($ranking, $this->level, $page->type);
										$changefreq = $this->get_page_changefreq($post->ID, 'post');
										
										if ($post->post_password == '') {
											
											$this->update_tree($post->ID, $post->post_modified, get_permalink($post->ID), $post->comment_count, $taxonomy->object_type[0], $this->level, $changefreq, $priority, $exclude);
										} 
									}
								}
							}
							else {

								if ($page->menu_item_parent == '0') { $this->level = 0; } else { $this->get_parent_level($items, $page->menu_item_parent, $level = 0); }
								if (get_post_meta($page->object_id, 'sitemap_priority', true)) { $ranking = get_post_meta($page->object_id, 'sitemap_priority', true); } else { $ranking = 0; }
								
								$priority = $this->get_priority($ranking, $this->level, $page->type);
								$changefreq = $this->get_page_changefreq($page->object_id, 'page');
								
								$this->update_tree($page->object_id, $data->post_modified, $page->url, $page->comment_count, $page->type, $this->level, $changefreq, $priority, $exclude);
							}
						}
					}
				}
			}
		}

		/**
		 * Loops through the blog articles and creates an array with sitemap pages
		 *
		 * @param $posts 	- array with publised posts
		 */
		
		private function generate_blogtree($posts) {

			if (is_array($posts) && count($posts) >= 1) {

				foreach ($posts as $key => $post) {

					$exclude = get_post_meta($post->ID, 'meta_robots', true);
					$template = esc_html(get_post_meta($post->ID, '_wp_page_template', true));

					if ((isset($post->post_password) && $post->post_password == '') && in_array($template, $this->excluded) != 1) {

						$level = $post->menu_order;
						$url = get_permalink($post->ID);

						$categories = wp_get_post_categories($post->ID);
						$tags = wp_get_post_tags($post->ID);
						$author = $post->post_author;

						$ranking = get_post_meta($post->ID, 'sitemap_priority', true) ? get_post_meta($post->ID, 'sitemap_priority', true) : 0;
						$priority = $this->get_priority($ranking, $level, $post->post_type);
						$changefreq = $this->get_page_changefreq($post->ID, $post->post_type);
						
						$this->update_tree($post->ID, $post->post_modified, $url, $post->comment_count, $post->post_type, $level, $changefreq, $priority, $exclude);

						$this->update_categories($categories);
						$this->update_tags($tags);
						$this->update_authors($author);
					}
				}

				// Adding the categories to the sitemap tree

				if (is_array($this->categories) && count($this->categories) >= 1) {

					foreach ($this->categories as $key => $id) {

						$post = get_posts(array('category' => $id, 'orderby' => 'date', 'numberposts' => 1));

						$url = get_category_link($id);
						$changefreq = $this->get_page_changefreq($id, 'taxonomy');
						$priority = $this->get_priority(0, 0, 'taxonomy');
						$comments = 0;
						$level = 0;

						$this->update_tree($id, $post[0]->post_modified, $url, $comments, 'category', $level, $changefreq, $priority, 0);
					}
				}

				// Adding the tags to the sitemap tree

				if (is_array($this->tags) && count($this->tags) >= 1) {

					foreach ($this->tags as $key => $id) {

						$term = get_term($id);
						$post = get_posts(array('tag' => $term->name, 'orderby' => 'date', 'numberposts' => 1));

						$url = get_term_link($id);
						$changefreq = $this->get_page_changefreq($id, 'tag');
						$priority = $this->get_priority(0, 0, 'tag');
						$comments = 0;
						$level = 0;

						$this->update_tree($id, $post[0]->post_modified, $url, $comments, 'tag', $level, $changefreq, $priority, 0);
					}
				}

				// Adding the authors to the sitemap tree

				if (is_array($this->authors) && count($this->authors) >= 1) {

					foreach ($this->authors as $key => $id) {

						$post = get_posts(array('author' => $id, 'orderby' => 'date', 'numberposts' => 1));

						$url = get_author_posts_url($id);
						$changefreq = $this->get_page_changefreq($id, 'author');
						$priority = $this->get_priority(0, 0, 'author');
						$comments = 0;
						$level = 0;

						$this->update_tree($id, $post[0]->post_modified, $url, $comments, 'author', $level, $changefreq, $priority, 0);
					}
				}
			}
		}

		/**
		 * Loops through a bbpress forum and creates an array with forums and topics
		 *
		 * @param $forums 	- array with publised forums
		 */
		
		private function generate_forumtree($forums) {

			if (is_array($forums) && count($forums) >= 1) {

				foreach ($forums as $key => $forum) {

					if ($forum->post_status === 'publish') {

						$topic = get_posts(array('post_type' => 'topic', 'post_parent' => $forum->ID, 'post_status' => 'publish', 'orderby' => 'date', 'numberposts' => 1));

						if (! empty($topic)) {

							$url = get_permalink($forum->ID);
							$changefreq = $this->get_page_changefreq($forum->ID, 'forum');
							$level = $forum->post_parent != 0 ? 1 : 0;
							$priority = $this->get_priority(0, $level, 'forum');
							$comments = 0;

							$this->update_tree($forum->ID, $topic[0]->post_modified, $url, $comments, 'forum', $level, $changefreq, $priority, 0);

							$this->update_forums($forum->ID);
						}
					}
				}

				// Adding the forum topics to the sitemap tree

				if (is_array($this->forums) && count($this->forums) >= 1) {

					foreach ($this->forums as $key => $id) {

						$topics = get_posts(array('post_type' => 'topic', 'post_parent' => $id, 'post_status' => 'publish', 'orderby' => 'date', 'numberposts' => -1));

						if (!empty($topics)) {

							foreach ($topics as $key => $topic) {

								$url = get_permalink($topic->ID);
								$changefreq = $this->get_page_changefreq($topic->ID, 'forum topic');
								$priority = $this->get_priority(0, 0, 'forum topic');
								$comments = $topic->comment_count;
								$level = 0;

								$this->update_tree($topic->ID, $topic->post_modified, $url, $comments, 'forum topic', $level, $changefreq, $priority, 0);

								$tags = get_the_terms($topic->ID, bbp_get_topic_tag_tax_id());
								empty($tags) ? '' : $this->update_topic_tags($tags);
							}
						}
					}
				}

				// Adding the forum topic tags to the sitemap tree

				if (is_array($this->topics) && count($this->topics) >= 1) {

					foreach ($this->topics as $key => $id) {

						$term = get_term($id);
						$post = get_posts(array('post_type' => 'topic', 'topic-tag' => $term->name, 'orderby' => 'date', 'numberposts' => 1));

						$url = get_term_link($id);
						$changefreq = $this->get_page_changefreq($id, 'forum tag');
						$priority = $this->get_priority(0, 0, 'forum tag');
						$comments = 0;
						$level = 0;

						$this->update_tree($id, $post[0]->post_modified, $url, $comments, 'forum tag', $level, $changefreq, $priority, 0);
					}
				}
			}
		}

		/**
		 * Loops through custom post types and creates an array with sitemap pages
		 *
		 * @param $posts 	- array with custom posts
		 */
		
		private function generate_typestree($posts) {

			if (is_array($posts) && count($posts) >= 1) {

				foreach ($posts as $key => $post) {

					$exclude = get_post_meta($post->ID, 'meta_robots', true);
					$template = esc_html(get_post_meta($post->ID, '_wp_page_template', true));

					if ((isset($post->post_password) && $post->post_password == '') && in_array($template, $this->excluded) != 1) {

						$level = $post->menu_order;
						$url = get_permalink($post->ID);

						$ranking = get_post_meta($post->ID, 'sitemap_priority', true) ? get_post_meta($post->ID, 'sitemap_priority', true) : 0;
						$priority = $this->get_priority($ranking, $level, $post->post_type);
						$changefreq = $this->get_page_changefreq($post->ID, $post->post_type);
						
						$this->update_tree($post->ID, $post->post_modified, $url, $post->comment_count, $post->post_type, $level, $changefreq, $priority, $exclude);
					}
				}
			}
		}
	}

?>