<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace MenuOptions;

	// Generates a drop down menu with all the pages available in the selected menu.

	class Dropdown extends \Walker {
		
		public $hidden = array();
		public $tree_type = array('post_type', 'taxonomy', 'custom');
		public $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');
		private $parents = array();
		private $childs = false;
		private $close = false;
		private $counter = 0;
		private $open = 0;

		/**
		 * Builds the menu item and adds the attributes needed
		 *
		 * @return string $html
		 */

		public function start_el(&$output, $item, $depth = 0, $arguments = array(), $id = 0) {

			$this->childs = false;

			if ($item->status != 'private' && $item->status != 'draft' && $item->status != 'pending' || $arguments->user === 'editor' || $arguments->user === 'admin') {

				if (!in_array($item->menu_item_parent, $this->hidden)) {

					$this->childs = true;

					$indent = ($depth) ? str_repeat("\t\t\t", $depth) : '';
					$classes = empty($item->classes) ? array() : (array) $item->classes;
					$identifiers = array('current-menu-item', 'current-menu-parent', 'current-menu-ancestor');
					$ancestor = array_intersect($identifiers, $classes);
					
					$url = esc_attr($item->url);
					$title = empty($item->attr_title) ? '' : ' title="'.esc_attr($item->attr_title).'"';
					$class = isset($classes[0]) && !empty($classes[0]) ? ' '.$classes[0] : '';
					$parent = in_array('menu-item-has-children', $classes) ? ' nav-parent' : '';
					$active = empty($ancestor) ? '' : ' active';
					$target = empty($item->target) ? '' : ' target="'.$item->target.'"';
					$rel = empty($item->xfn) ? '' : ' rel="'.esc_attr($item->xfn).'"';

					$link = $indent."\t\t\t\t".'<li class="nav-item'.$parent.''.$class.''.$active.'"><a href="'.$url.'" class="nav-link"'.$rel.''.$target.''.$title.'>'.apply_filters('the_title', $item->title, $item->ID).'</a>';

					$output .= apply_filters('walker_nav_menu_start_el', $link, $item, $depth, $arguments);
				}
				else {
				
					if (!in_array($item->ID, $this->hidden)) $this->hidden[] = $item->ID;	
				}
			}
		}

		/**
		 * Closes the menu item after all levels of sub menus are created
		 *
		 * @return string $html
		 */

		public function end_el(&$output, $item, $depth = 0, $arguments = array(), $id = 0) {
		
			if ($item->status != 'private' && $item->status != 'draft' && $item->status != 'pending' || $arguments->user == 'editor' || $arguments->user == 'admin') {
				
				if (!in_array($item->menu_item_parent, $this->hidden)) {

					$output .= '</li>'."\n";

					$menu = apply_filters('walker_nav_menu_end_el', $output, $item, $depth, $arguments);
					$output = strcmp($output, $menu) == 0 ? $output : $menu;
				}
			}
		}

		/**
		 * Starts a new submenu and adds a class with the menu depth
		 *
		 * @return string $html
		 */

		public function start_lvl(&$output, $depth = 0, $arguments = array()) {

			$indent = str_repeat("\t", $depth);

			if ($depth >= $arguments->level) {

				if ($this->childs === true) {

					$this->close = true;
					$this->open = $this->open + 1;


					$output .= "\n\n".$indent."\t\t\t\t\t".'<nav class="sub-menu level-'.($depth - $arguments->level + 1).'">'."\n";
					$output .= $indent."\t\t\t\t\t\t".'<ul class="nav">'."\n";
				}
				else {

					$this->close = false;
					$this->counter = $this->counter + 1;
				}
			}
		}

		/**
		 * Ends a submenu that was started in the previous function
		 *
		 * @return string $html
		 */

		public function end_lvl(&$output, $depth = 0, $arguments = array()) {

			$indent = str_repeat("\t", $depth);

			if ($depth >= $arguments->level) {

				if ($this->open >= 1 && $this->close == true && $this->counter == 0) {

					$this->open = $this->open - 1;
					
					if ($this->open >= 1) { $this->close = true; } else { $this->close = false; }
					
					$output .= $indent."\t\t\t\t\t\t".'</ul>'."\n";
					$output .= $indent."\t\t\t\t\t".'</nav>'."\n";
				}
				else {

					$this->close = true;
					$this->counter = $this->counter - 1;
				}
			}
		}
	}

?>