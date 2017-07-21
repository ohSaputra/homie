<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace MenuOptions;

	// Generates a breadcrumb menu, based on the custom menu structure.

	class Breadcrumb extends \Walker {
		
		public $tree_type = array('post_type', 'taxonomy', 'custom');
		public $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');
		private $position = 1;
		private $child = false;
		private $origin = false;
		private $rendered = false;
		private $home = false;

		/**
		 * Builds the menu item and adds the attributes needed
		 *
		 * @return string $html
		 */

		public function start_el(&$output, $item, $depth = 0, $arguments = array(), $id = 0) {

			$url = '';
			$label = '';

			$classes = empty($item->classes) ? array() : (array) $item->classes;
			$identifiers = array('current-menu-item', 'current-menu-parent', 'current-menu-ancestor');
			$ancestor = array_intersect($identifiers, $classes);
			
			if ($ancestor && $this->rendered === false) {

				if (in_array('current-menu-parent', $ancestor) && $item->type === 'taxonomy') { $this->child = true; } else { $this->child = false; }

				$url = esc_attr($item->url);
				$label = apply_filters('the_title', $item->title, $item->ID);
				$title = empty($item->attr_title) ? $label : esc_attr($item->attr_title);

				if ($depth === 0) {

					$output .= "\t\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.get_site_url().'" property="item" typeof="WebPage" title="'.__('Home', 'theme translation').'"><span property="name">'.__('Home', 'theme translation').'</span><meta property="position" content="1"></a></li>'."\n";
					
					$this->home = true;
					$this->position += 1;
				}
				else if ($depth >= 1 && $this->home === false) {

					$output .= "\t\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.get_site_url().'" property="item" typeof="WebPage" title="'.__('Home', 'theme translation').'"><span property="name">'.__('Home', 'theme translation').'</span><meta property="position" content="1"></a></li>'."\n";
					
					$this->position += 1;
				}

				if (in_array('current-menu-item', $ancestor) && $this->origin === false) {

					$output .= "\t\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.$url.'" property="item" typeof="WebPage" title="'.$title.'"><span property="name">'.$label.'</span><meta property="position" content="'.$this->position.'"></a></li>'."\n";

					$this->child = false;
					$this->rendered = true;

					$this->position += 1;
				}
				else if (in_array('current-menu-parent', $ancestor) || in_array('current-menu-ancestor', $ancestor)) {

					$output .= "\t\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.$url.'" property="item" typeof="WebPage" title="'.$title.'"><span property="name">'.$label.'</span><meta property="position" content="'.$this->position.'"></a></li>'."\n";
				
					$this->position += 1;
				}
			}
			else if ($this->child === true) {

				$url = get_permalink();
				$label = trim(wp_title('', false, ''));
				$title = $label;

				$output .= "\t\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.$url.'" property="item" typeof="WebPage" title="'.$title.'"><span property="name">'.$label.'</span><meta property="position" content="'.$this->position.'"></a></li>'."\n";

				$this->child = false;
				$this->origin = true;
				$this->rendered = true;

				$this->position += 1;
			}
		}
	}

?>