<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Generates the menu structure of a pagination menu

	class Pagination {

		private $menu;
		private $wp_query;
		private $query;
		
		public function __construct() {
			
			global $wp_query;
			global $query;

			$this->menu = '';
			$this->wp_query = $wp_query;
			$this->query = $query;
		}

		/**
		 * Returns the HTML structure of a menu
		 *
		 * @return string $html
		 */

		public function html($arguments = array()) {
			
			$output = "";

			$defaults = array(

				'page'			=> null,
				'pages'			=> null, 
				'range'			=> 5,
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
						
				$total = !empty($this->query) ? count($this->query) : $this->wp_query->found_posts;
		
				wp_reset_query();
				
				$page = get_query_var('paged');
				$page = !empty($page) ? intval($page) : 1;
				$posts_per_page = intval(get_query_var('posts_per_page'));
				$pages = intval(ceil($total / $posts_per_page));
			}
				
			if ($pages > 1) {
				
				$output .= $before;
		
				if ($page > 1 && !empty($prevlabel)) {
		
					$output .= '<a href="'.get_pagenum_link($page - 1).'" class="prev" title="'.__('Previous page', 'theme translation').'">'.$previcon.''.$prevlabel.'</a>';
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

				if ($end > $pages) {

					$end = $pages;
				}
				
				$output .= $this->loop($pages, $start, $end, $page);
				
				if ($page < $pages && !empty($nextlabel)) {
		
					$output .= '<a href="'.get_pagenum_link($page + 1).'" class="next" title="'.__('Next page', 'theme translation').'">'.$nextlabel.''.$nexticon.'</a>';
				}
				
				$output .= '<em>'.$title.' '.$page.' '.$separator.' '.$pages.'</em>'.$after;
			}
			
			return $output;
		}

		/**
		 * Returns pagination buttons for each accessible page
		 *
		 * @return string $html
		 */

		private function loop($pages, $start, $max, $page = 0) {
			
			$output = "";
		
			for ($i = $start; $i <= $max; $i++) {
				
				if ($pages > $max && $i === $max) {

					$output .= '<span>...</span>';
				}

				$output .= ($page === intval($i)) ? '<strong>'.$i.'</strong>' : '<a href="'.get_pagenum_link($i).'" title="'.__('Page', 'theme translation').' '.$i.'">'.$i.'</a>';
			}

			return $output;
		}
	}
?>