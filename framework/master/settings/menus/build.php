<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace MenuOptions;
	
	// Generates the menu structure of a custom menu
	//
	// menu 		= The menu name of the menu to be used under the theme menu settings.
	// class 		= The CSS class name to be used on the HTML output.
	// prefix 		= The CSS class name prefix to be used on the HTML output (class="*** prefix-***").
	// nav 			= The bootstrap nav class type to be on the HTML output (tabs, pills, tree).
	// id 			= The identification name to be used on the HTML output.
	// title 		= Option to add a title inside the NAV element.
	// heading 		= Option to change the title heading tag, default is H5.
	// level 		= The start level where the depth should start to count from.
	// depth 		= The depth of levels in the menu items hierarchy to be included. 0 means all. Default is 1.
	// wrapper 		= Option to turn on or off the wrapper element (NAV). Default is true.
	// substitute 	= Option to enable or disable the option to show any type of available menu (true or false).
	// container 	= The container element to be used on the HTML output (UL or OL). Default is <UL>
	// before 		= The custom text that can be added before the anchor element.
	// after 		= The custom text that can be added after the anchor element.
	// link before 	= The custom text that can be added before the anchor text.
	// link after 	= The custom text that can be added after the anchor text.
	// schema 		= The schema ORG name for any type of microdata to be used on the HTML output.
	// location 	= The menu location name of the menu to be used. Must be registered with register_nav_menu() in order to be selectable by the user.
	// walker 		= The instance of a custom walker class. Default empty.

	class Build {

		private $menu;
		private $level;
		private $tree;
		private $singular;
		private $queried_object;
		private $active;
		private $type;
		
		public function __construct() {
						
			$this->menu = '';
		}

		/**
		 * Returns the HTML structure of a menu
		 *
		 * @return string $html
		 */

		public static function html($arguments = array()) {
			
			global $user_identity;
			
			$defaults = array('menu' => '', 'class' => '', 'prefix' => '', 'nav' => '', 'id' => '', 'title' => '', 'heading' => 'h5', 'level' => 0, 'depth' => 1, 'container' => 'ul', 'wrapper' => true, 'substitute' => false, 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'schema' => '', 'location' => '', 'walker' => '');

			$menu = '';
			$containers = array('ul', 'ol');
			
			$settings = wp_parse_args($arguments, $defaults);
			$settings = (object) $settings;

			$settings->user = strtolower($user_identity);

			// Get the nav menu based on the requested menu

			$object = wp_get_nav_menu_object($settings->menu);

			// Get the nav menu based on the location

			if (! $object && $settings->location && ($locations = get_nav_menu_locations()) && isset($locations[$settings->location])) {

				$object = wp_get_nav_menu_object($locations[$settings->location]);
			}

			// get the first menu that has items if we still can't find a menu

			if (! $object && ! $settings->location && $settings->substitute === true) {

				$menus = wp_get_nav_menus();

				foreach ($menus as $temp) {

					if ($items = wp_get_nav_menu_items($temp->term_id, array('update_post_term_cache' => false))) {
						
						$object = $temp;
						break;
					}
				}
			}
			
			// If the menu exists, get its items

			if ($object && ! is_wp_error($object) && ! isset($items)) {

				$items = wp_get_nav_menu_items($object->term_id, array('update_post_term_cache' => false));
			}

			// If no items was found, bail

			if (!isset($items))
				return false;
				
			if (isset($items) && count($items) == 0)
				return false;
			
			// Adds class property classes for the current context (level and object)

			_wp_menu_item_classes_by_context($items);

			// Sorts the menu items based on children

			$sorted = $children = array();

			foreach ((array) $items as $item) {
				
				$sorted[$item->menu_order] = $item;
				
				if ($item->menu_item_parent) { $children[$item->menu_item_parent] = true; }
			}

			// Adds a has children class where applicable

			if ($children) {
				
				foreach ($sorted as &$item) {
					
					if (isset($children[$item->ID])) { $item->classes[] = 'menu-item-has-children'; }
				}
			}

			unset($items, $item);

			// Filter the sorted list of menu item objects before generating the menu's HTML

			$sorted = apply_filters('wp_nav_menu_objects', $sorted, $settings);

			// Call to walker class that will generate the menu items

			$output = self::walker($sorted, $settings->depth, $settings);

			unset($sorted);

			$class = empty($settings->class) ? 'menu' : esc_attr($settings->class);
			$prefix = empty($settings->prefix) ? '' : ' '.esc_attr($settings->prefix);
			$container = in_array($settings->container, $containers) ? $settings->container : 'ul';
			$heading = empty($settings->heading) ? 'h5' : $settings->heading;
			$title = empty($settings->title) ? '' : "\t\t\t".'<'.$heading.'>'.$settings->title.'</'.$heading.'>'."\n";

			$menu .= "\n";
			$menu .= "\t".'<!-- '.$class.' starts -->'."\n";
			$menu .= $settings->wrapper === true ? "\t\t".'<nav class="'.$class.''.$prefix.'"'.sprintf($settings->id ? ' id="'.esc_attr($settings->id).'"' : '').' role="navigation">'."\n" : '';
			$menu .= $title;
			$menu .= "\t\t\t".'<'.$container.''.sprintf($settings->nav ? ' class="nav '.esc_attr($settings->nav).'"' : '').''.sprintf($settings->schema ? ' vocab="http://schema.org/" typeof="'.esc_attr($settings->schema).'"' : '').'>'."\n";
			$menu .= $output;
			$menu .= "\t\t\t".'</'.$container.'>'."\n";
			$menu .= $settings->wrapper === true ? "\t\t".'</nav>'."\n" : '';
			$menu .= "\t".'<!-- '.$class.' ends -->'."\n";
			$menu .= "\n";

			return ($output) ? $menu : false;
		}

		/**
		 * Returns the HTML structure of menu items
		 *
		 * @param $items 		- array of menu items
		 * @param $depth 		- an integer of how many levels of menu options to be used
		 * @param $settings 	- array with menu settings
		 *
		 * @return string $html
		 */

		public static function walker($items, $depth, $settings) {

			$walker = empty($settings->walker) ? new \Walker_Nav_Menu : $settings->walker;
			$arguments = array($items, $depth, $settings);

			return call_user_func_array(array(&$walker, 'walk'), $arguments);
		}
	}
?>