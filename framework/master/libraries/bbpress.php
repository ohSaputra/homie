<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Class to setup and control custom bbpress features

	class bbPress {

		public function __construct() {

			add_filter('bbp_get_dropdown', array($this, 'add_class'));
			add_filter('bbp_get_form_forum_status_dropdown', array($this, 'add_class'));
			add_filter('bbp_get_form_forum_type_dropdown', array($this, 'add_class'));
			add_filter('bbp_get_form_forum_visibility_dropdown', array($this, 'add_class'));
			add_filter('bbp_get_form_topic_type_dropdown', array($this, 'add_class'));

			add_filter('bbp_get_forum_pagination_count', array($this, 'forum_count'));
			add_filter('bbp_get_topic_pagination_count', array($this, 'topic_count'));
			add_filter('bbp_get_search_pagination_count', array($this, 'search_count'));

			add_action('wp_enqueue_scripts', array($this, 'remove_enqueued_css'));
			add_action('wp_print_styles', array($this, 'remove_printed_css'), 100);
			add_action('wp_print_scripts', array($this, 'remove_printed_scripts'), 100);
		}

		/**
		 * Disables enqueued stylesheet files
		 *
		 */

		public static function remove_enqueued_css() {

			wp_dequeue_style('bbp-child-bbpress');
			wp_dequeue_style('bbp-parent-bbpress');
			wp_dequeue_style('bbp-default-bbpress');
			wp_dequeue_style('bbp-default');
		}

		/**
		 * Disables embeded stylesheet code
		 *
		 */

		public static function remove_printed_css() {

			wp_dequeue_style('basic-comment-quicktags');
			wp_dequeue_style('editor-buttons');
		}

		/**
		 * Disables embeded javascript code
		 *
		 */

		public static function remove_printed_scripts() {

			$quicktags = get_option('ippy_bcq_options');
			$template = get_current_template();
			
			if (($template === 'forum' || $template === 'template-support') && isset($quicktags['bbpress']) && $quicktags['bbpress'] === 1) {
			
				wp_deregister_script('jquery');	
			}
		}

		/**
		 * Adds class attribute to form inputs
		 *
		 * @param $output 	- html output
		 *
		 */

		public static function add_class($output) {

			$output = str_replace('<select', '<select class="select form-control"', $output);

			return $output;
		}

		/**
		 * Generates a pagination menu for forum topics
		 *
		 * @param $arguments 	- array with arguments
		 *
		 * @return string $html
		 *
		 */

		public static function pagination($arguments = null) {

			$defaults = array(
				'page'			=> null,
				'pages'			=> null, 
				'total'			=> null, 
				'topic'			=> null, 
				'type'			=> null,
				'range'			=> 4,
				'before'		=> "\n".'<!-- pagination starts -->'."\n\t".'<nav class="pagination" role="navigation">'."\n",
				'after'			=> "\n\t".'</nav>'."\n".'<!-- pagination ends -->'."\n",
				'title'			=> __('Page:', 'theme translation'),
				'separator'		=> __('of', 'theme translation'),
				'nextlabel'		=> __('NEXT', 'theme translation'),
				'nexticon'		=> '<i class="icon i-pointer-left i-left i-1x"></i>',
				'prevlabel' 	=> __('PREV', 'theme translation'),
				'previcon' 		=> '<i class="icon i-pointer-right i-right i-1x"></i>',
				'lastpage' 		=> __('LAST &raquo;', 'theme translation')
			);
			
			$extract = wp_parse_args($arguments, $defaults);
			extract($extract, EXTR_SKIP);
			
			if (!$page && !$pages) {
		
				if ($type == 'single-topic') { 
					
					$bbp = bbpress();
					
					$topic = empty($topic) ? bbp_get_topic_id() : $topic;
					$total = empty($total) ? bbp_get_topic_reply_count($topic, true) + 1 : $total;
					$posts_per_page = empty($bbp->reply_query->query_vars['hierarchical']) ? intval(bbp_get_replies_per_page()) : -1;
				}
				else if ($type == 'search-topic') { 
					
					$bbp = bbpress();
					
					$total = empty($total) ? $bbp->search_query->found_posts : $total;
					$posts_per_page = intval(bbp_get_topics_per_page());
				}
				else {
					
					$topic = empty($topic) ? bbp_get_forum_id() : $topic;
					$total = empty($total) ? bbp_get_forum_topic_count($topic, false) : $total;
					$posts_per_page = intval(bbp_get_topics_per_page());
					
					$subforum = bbp_get_forum_subforum_count($topic);
					$stickies = count(bbp_get_stickies($topic));
					$modulo = $stickies % 2;
				}
				
				$page = get_query_var('paged');
				$page = !empty($page) ? intval($page) : 1;
				$pages = intval(ceil($total / $posts_per_page));
			}
		
			$output = "";

			if ($pages > 1) {
				
				$output .= $before;
				
				if ($page > 1 && !empty($prevlabel)) {
		
					$output .= '<a href="'.get_pagenum_link($page - 1).'" title="'.__('Previous page', 'theme translation').'">'.$previcon.''.$prevlabel.'</a>';
				}
				
				if ($page < $range) {
					
					$start = 1;
					$end = $range;
					
					if ($pages < $range) {
						$end = $pages;
					}
				}
				else if ($page == $range) {
					
					$start = ($range - $page) + 2;
					$end = $range + 1;
				}
				else if ($page > $range) {
					
					if ($page == $pages) {
						
						$start = ($page - $range) + 1;
						$end = ($start + $range) - 1;
					}
					else {
						
						$start = ($page - $range) + 2;
						$end = ($start + $range) - 1;
					}
				}
				
				$output .= self::pagination_loop($start, $end, $page);

				if ($page < $pages && !empty($nextlabel)) {
		
					$output .= '<a href="'.get_pagenum_link($page + 1).'" title="'.__('Next page', 'theme translation').'">'.$nextlabel.''.$nexticon.'</a>';
				}
				
				$output .= '<em>'.$title.' '.$page.' '.$separator.' '.$pages.'</em>'.$after;
			}
			
			return $output;
		}

		/**
		 * Generates the pagination links
		 *
		 * @param $start 	- start position
		 * @param $end 		- end position
		 * @param $page 	- page id
		 *
		 * @return string $html
		 *
		 */

		public static function pagination_loop($start, $end, $page = 0) {

			$output = "";
		
			for ($i = $start; $i <= $end; $i++) { $output .= ($page === intval($i)) ? '<strong>'.$i.'</strong>' : '<a href="'.get_pagenum_link($i).'" title="'.__('Page', 'theme translation').' '.$i.'">'.$i.'</a>'; }
			
			return $output;
		}

		/**
		 * Filters the forum pagination counter
		 *
		 * @param $string 	- number of forums
		 *
		 * @return string
		 *
		 */

		public static function forum_count($string) {

			$string = self::pagination_count($string, $type = 'forum');
			
			return $string;
		}

		/**
		 * Filters the topic pagination counter
		 *
		 * @param $string 	- number of topics
		 *
		 * @return string
		 *
		 */

		public static function topic_count($string) {

			$string = self::pagination_count($string, $type = 'topic');
			
			return $string;
		}

		/**
		 * Filters the search pagination counter
		 *
		 * @param $string 	- number of search results
		 *
		 * @return string
		 *
		 */

		public static function search_count($string) {

			$string = self::pagination_count($string, $type = 'search');
			
			return $string;
		}

		/**
		 * Returns the pagination counter
		 *
		 * @param $string 	- html content
		 * @param $type 	- typ of page or component
		 *
		 * @return string $html
		 *
		 */

		public static function pagination_count($string, $type) {

			$content = '';
			
			$result = preg_match_all("/[0-9]+/", $string, $matches);
			
			if (! empty($result) && isset($matches[0]) && count($matches[0]) >= 4) {
				
				$content .= '<!-- pages starts -->'."\n";
				$content .= "\t".'<div class="pages">'.sprintf(__('Viewing topics %s of %s total', 'support translation'), '<strong>'.$matches[0][1].' - '.$matches[0][2].'</strong>', $matches[0][3]).'</div>'."\n";
				$content .= '<!-- pages ends -->'."\n\n";
			}
			else if (! empty($result) && isset($matches[0]) && count($matches[0]) >= 2) {
				
				$content .= '<!-- pages starts -->'."\n";
				$content .= "\t".'<div class="pages">'.sprintf(__('Viewing topic %s of %s total', 'support translation'), '<strong>'.$matches[0][0].'</strong>', $matches[0][1]).'</div>'."\n";
				$content .= '<!-- pages ends -->'."\n\n";
			}
			else {
				
				$content .= '<!-- pages starts -->'."\n";
				$content .= "\t".'<div class="pages">'.$string.'</div>'."\n";
				$content .= '<!-- pages ends -->'."\n\n";
			}
			
			return $content;
		}

		/**
		 * Returns the status icon of a topic
		 *
		 * @param $id 			- topic id
		 * @param $progress 	- status type
		 *
		 * @return string
		 *
		 */

		public static function get_topic($id, $progress = false) {

			$status = bbp_is_topic_sticky(bbp_get_topic_id(), false) || bbp_is_topic_super_sticky(bbp_get_topic_id()) ? '3' : get_post_meta($id, 'topic_status', true);
			
			switch ($status) {
				
				case '0':
				
					$status = 'progress';
					$label = __('Reply', 'theme translation');
					
					break;
				case '1':
				
					$status = 'resolved';
					$label = __('Resolved', 'theme translation');
					
					break;
				case '2':
				
					$status = 'invalid';
					$label = __('Invalid', 'theme translation');
					
					break;
				case '3':
				
					$status = 'sticky';
					$label = __('Announcement', 'theme translation');
					
					break;
				default:
				
					$status = 'reply';
					$label = __('Reply', 'theme translation');
			}
			
			return empty($progress) ? $status : $label;
		}

		/**
		 * Returns the author role name
		 *
		 * @param $role 	- role type
		 *
		 * @return string
		 *
		 */

		public static function get_author_role($role) {
					
			switch ($role) {
				
				case 'Keymaster':
					$name = 'Keymaster';
					break;
				case 'Moderator':
					$name = 'Moderator';
					break;
				case 'Participant':
					$name = 'Participant';
					break;
				case 'Member':
					$name = 'Member';
					break;
				case 'Guest':
					$name = 'Guest';
					break;
				case 'Spectator':
					$name = 'Spectator';
					break;
				case 'Inactive':
					$name = 'Inactive';
					break;
				case 'Blocked':
					$name = 'Blocked';
					break;
				default:
					$name = '';
			}
			
			return $name;
		}

		/**
		 * Returns the author role class
		 *
		 * @param $role 	- role type
		 *
		 * @return string
		 *
		 */

		public static function get_author_class($role) {
			
			$class = $role == 'Keymaster' ? 'support-user support-admin' : 'support-user';
			
			return $class;
		}

		/**
		 * Returns the subscribe link
		 *
		 * @return string 	- html
		 *
		 */

		public static function get_subscribe_link() {

			$link = '';
		
			if (!bbp_is_subscriptions_active()) { return; }
					
			$subscribe_attr = return_html_attributes(bbp_get_user_subscribe_link());
			$subscribe_data = return_data_attributes(bbp_get_user_subscribe_link());
			$subscribe_label = (isset($subscribe_attr['href']) && strpos($subscribe_attr['href'], 'unsubscribe') !== FALSE) ? __('Unsubscribe', 'support translation') : __('Subscribe', 'support translation');
			
			$link = isset($subscribe_attr['href']) ? '<a href="'.$subscribe_attr['href'].'" class="trigger '.$subscribe_attr['class'].'" rel="'.$subscribe_attr['rel'].'" '.$subscribe_data.' title="'.$subscribe_label.'">'.$subscribe_label.'</a>' : '';
			
			return $link;
		}

		/**
		 * Returns the favorite link
		 *
		 * @return string 	- html
		 *
		 */

		public static function get_favorites_link() {

			$link = '';
		
			if (!bbp_is_favorites_active()) { return; }
			
			$favorites_attr = return_html_attributes(bbp_get_user_favorites_link());
			$favorites_data = return_data_attributes(bbp_get_user_favorites_link());
			$favorites_label = (isset($favorites_attr['href']) && strpos($favorites_attr['href'], 'remove') !== FALSE) ? __('Remove from Favorites', 'support translation') : __('Add as Favorite', 'support translation');
			
			$link = isset($favorites_attr['href']) ? '<a href="'.$favorites_attr['href'].'" class="trigger '.$favorites_attr['class'].'" rel="'.$favorites_attr['rel'].'" '.$favorites_data.' title="'.$favorites_label.'">'.$favorites_label.'</a>' : '';
			
			return $link;
		}

		/**
		 * Returns a menu with topic tags
		 *
		 * @param $id 		- id of page
		 *
		 * @return string 	- html
		 *
		 */

		public static function get_topic_tag_menu($id) {

			$menu = '';
		
			$taglist = bbp_get_topic_tag_list($id, array('before' => '', 'sep' => ' ', 'after' => ''));
			
			if (!empty($taglist)) {
				
				$tag = 'a';
				$match = preg_match_all('/<'.$tag.'[^>]*>(.*?)<\/'.$tag.'>/si', str_replace('\'', '"', $taglist), $matches);
								
				$menu .= '<!-- tags starts -->'."\n";
				$menu .= "\t".'<div class="tag-list">'."\n";
				
				foreach ($matches[1] as $id => $key) {

					$separator = count($matches[1]) === $id + 1 ? '' : ', ';
					
					$href = return_all_href_attributes($matches[0][$id]);
					$menu .= "\t\t".'<a href="'.$href[0].'" class="tag" rel="tag" title="'.$key.'">'.$key.'</a>'.$separator."\n";
				}
							
				$menu .= "\t".'</div>'."\n";
				$menu .= '<!-- tags ends -->'."\n";
			}
			
			return $menu;
		}

		/**
		 * Returns a user avatar image
		 *
		 * @param $id 		- user id
		 * @param $size 	- image size
		 *
		 * @return string 	- html
		 *
		 */

		public static function get_avatar($id, $size = 80, $alt = '') {

			$output = '';

			// $headers = @get_headers('https://www.gravatar.com/avatar/'.md5(strtolower(trim($id))).'?d=404');
			// $valid = !preg_match("|200|", $headers[0]) ? FALSE : TRUE;
			// $img = get_bloginfo('stylesheet_directory').'/img/avatar.png';
			
			$avatar = get_avatar($id, $size, '', $alt);
			$avatar = return_html_attributes($avatar);

			$output = '<img src="'.$avatar['src'].'" height="'.round($avatar['height'] / 2).'" width="'.round($avatar['width'] / 2).'" alt="'.$alt.'" />'."\n";

			return $output;
		}
	}

?>