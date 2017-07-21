<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016
	
		
	/**
	 * Wraps content of a widget with a wrapper
	 *
	 * @return string
	 */

	if (! function_exists('widget_content_wrap')) :

		function widget_content_wrap($params) {
			
			global $wp_registered_widgets;

			$wp_widgets = array('widget_calendar', 'widget_nav_menu', 'widget_rss', 'widget_search', 'widget_text');
			$wp_title_widgets = array('widget_archive', 'widget_categories', 'widget_links', 'widget_meta', 'widget_recent_comments', 'widget_recent_entries', 'widget_tag_cloud', 'widget_pages');

			$callback = $wp_registered_widgets[$params[0]['widget_id']]['callback'][0];
			$settings = $callback->get_settings();
			$settings = $settings[$params[1]['number']];
			$class = $callback->widget_options['classname'];

			// All wordpress widgets that outputs a title as default

			if (in_array($class, $wp_title_widgets)) {

				$params[0]['before_widget'] = str_replace('_', '-', $params[0]['before_widget']);
				$params[0]['after_title'] .= "\t\t".'<div class="widget-body">'."\n\n";
				$params[0]['after_widget'] = "\n\n\t\t".'</div>'."\n".$params[0]['after_widget'];
			}

			// All other wordpress widgets

			if (in_array($class, $wp_widgets)) {
				
				$params[0]['before_widget'] = str_replace('_', '-', $params[0]['before_widget']);
				$params[0]['before_widget'] .= isset($settings['title']) && empty($settings['title']) ? "\t\t".'<div class="widget-body">'."\n\n" : '';
				$params[0]['after_title'] .= isset($settings['title']) && empty($settings['title']) ? '' : "\t\t".'<div class="widget-body">'."\n\n";
				$params[0]['after_widget'] = "\n\n\t\t".'</div>'."\n".$params[0]['after_widget'];
			}

			return $params;
		}

	endif;
	add_filter('dynamic_sidebar_params', 'widget_content_wrap');
	
?>