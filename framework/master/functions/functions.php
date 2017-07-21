<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016
	
	

	/**
	 * Fires the theme footer action
	 *
	 * @return call action
	 */

	if (! function_exists('get_theme_footer')) :

		function get_theme_footer() {
			
			do_action('theme_footer');
		}

	endif;

	/**
	 * Reads a cookie and returns a class for lazy font loading
	 *
	 * @return call action
	 */

	if (! function_exists('get_fonts_loaded')) :

		function get_fonts_loaded() {
									
			$output = isset($_COOKIE['lazy-fonts-loaded']) && $_COOKIE['lazy-fonts-loaded'] == 1 ? ' class="fonts-loaded"' : '';

			return $output;
		}

	endif;

	/**
	 * Returns the id of the current page
	 *
	 * @return string
	 */

	if (! function_exists('get_page_id')) :

		function get_page_id() {
			
			global $post;
			
			if (is_category()) { $id = get_term_by('name', single_cat_title('', false), 'category')->term_id; } else if (is_tax()) { $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy')); $id = $term->term_id; } else if (isset($post->ID)) { $id = $post->ID; } else { $id = ''; }
			
			return $id;
		}

	endif;
		
	/**
	 * Returns the type of the current page
	 *
	 * @return string
	 */

	if (! function_exists('get_page_type')) :

		function get_page_type() {
			
			global $post;
			global $wp_query;
					
			if (is_page_template()) { $type = get_current_template(); } else if (is_home()) { $type = 'home'; } else if (is_category()) { $type = 'category'; } else if (is_single()) { $type = get_post_type($post->ID); } else if (is_page()) { $type = 'page'; } else if (is_tax()) { $term = $wp_query->get_queried_object(); $type = str_replace('_', '-', $term->taxonomy); } else if (is_tag()) { $type = 'tag'; } else if (is_author()) { $type = 'author'; } else if (is_archive()) { $type = 'archive'; } else if (is_search()) { $type = 'search'; } else if (is_404()) { $type = '404'; } else if (is_paged()) { $type = 'paged'; } else { $type = ''; }
			
			return $type;
		}

	endif;
		
	/**
	 * Returns the title of the current page
	 *
	 * @return string
	 */

	if (! function_exists('get_page_title')) :

		function get_page_title() {
					
			global $wp_query;
					
			if (is_tax() || is_tag()) { $term = $wp_query->get_queried_object(); $title = $term->name; } else if (is_front_page()) { $title = get_theme_option('seo_options', 'title'); } else if (is_search()) { $title = __('Search', 'theme translation'); } else { $title = wp_title('', false, ''); }
			
			return trim($title);
		}

	endif;
		
	/**
	 * Returns the template of the current page
	 *
	 * @return string
	 */

	if (! function_exists('get_current_template')) :

		function get_current_template() {
			
			global $wp_query;
			
			$page = $wp_query->get_queried_object();
			$template = isset($page->ID) ? $template = str_replace('.php', '', esc_html(get_post_meta($page->ID, '_wp_page_template', true))) : $template = 'template';
			
			return $template;
		}

	endif;
	
	/**
	 * Returns the page template in use for a certain page
	 *
	 * @return string
	 */

	if (! function_exists('get_current_page_template')) :

		function get_current_page_template() {
			
			global $template;
			
			$file = basename($template, '.php');
					
			return $file;
		}

	endif;

	/**
	 * Returns the current page URL
	 *
	 * @param $query 	- true or false to include the query string in the url
	 *
	 * @return string
	 */

	if (! function_exists('get_current_page_url')) :

		function get_current_page_url($query = false) {
			
			global $wp;
				
			$url = add_query_arg($wp->query_string, '', home_url($wp->request));
			$url = $query === false ? reset((explode('?', $url))).'/' : $url;
					
			return $url;
		}

	endif;

	/**
	 * Returns the value of a theme options field
	 *
	 * @param $options 	- string of settings to fetch
	 * @param $field	- string of field to fetch
	 *
	 * @return mixed
	 */

	if (! function_exists('get_theme_option')) :

		function get_theme_option($options, $field = null) {
			
			$options = strpos($options, THEME_NAME) === 0 ? get_option($options) : get_option(THEME_NAME.'_'.$options);
			if (empty($field)) { $content = $options; } else { if (isset($options[$field])) { $content = $options[$field]; } else { $content = ''; } }
			
			$content = gettype($content) == 'string' ? stripslashes($content) : $content;
					
			return $content;
		}

	endif;

	/**
	 * Returns the value of a meta box options field
	 *
	 * @param $id 		- id of current page
	 * @param $field	- string of field to fetch
	 * @param $options 	- whether to return a single value
	 *
	 * @return mixed
	 */
	
	if (! function_exists('get_meta_option')) :

		function get_meta_option($id, $field = null, $single = true) {
			
			$content = isset($id) ? get_post_meta($id, $field, $single) : '';
						
			return $content;
		}

	endif;
	
	/**
	 * Returns the user role for the current user on the website
	 *
	 * @return string
	 */
	
	if (! function_exists('get_user_role')) :

		function get_user_role() {
			
			global $current_user;
			
			return $user_role = (isset($current_user->roles[0])) ? $current_user->roles[0] : '';
		}

	endif;
	
	/**
	 * Returns a url from a link element
	 *
	 * @return string
	 */

	if (! function_exists('get_content_url')) :

		function get_content_url($link) {
			
			$id = explode(',', $link);
			$type = isset($id[0]) ? $id[0] : '';

			switch ($type) {
				case 'category':
					
					$url = isset($id[1]) ? get_category_link($id[1]) : '';
				
				break;
				case 'tag':
					
					$url = isset($id[1]) ? get_tag_link($id[1]) : '';
					
				break;
				case 'term':
					
					$url = isset($id[1]) ? get_term_link($id[1], $id[0]) : '';
					
				break;
				case 'link':
									
					$bookmark = isset($id[1]) ? (array)get_bookmark($id[1]) : '';
					$url = empty($bookmark['link_url']) ? '' : $bookmark['link_url'];
										
				break;
				default:
				
					$url = isset($id[1]) ? get_permalink($id[1]) : '';
				
				break;
			}

			return $url;
		}

	endif;

	/**
	 * Returns the target attribute for a link
	 *
	 * @return string
	 */
	
	if (! function_exists('get_target_attribute')) :

		function get_target_attribute($href) {
			
			$external = preg_match('~\bhttps?://(?:www\.)?(?!'.preg_replace('/^www\./', '', $_SERVER['SERVER_NAME']).')[^\s/]+(?:/[^\s/]+)*/?~i', $href, $external) ? $external[0] : '';
			$target = empty($external) ? '' : ' target="_blank"';
			
			return $target;
		}

	endif;
	
	/**
	 * Returns an array with all html attributes
	 *
	 * @return array
	 */
	
	if (! function_exists('return_html_attributes')) :

		function return_html_attributes($tag, $attributes = array('href', 'src', 'class', 'width', 'height', 'alt', 'title', 'rel', 'target')) {
				
			$result = array();
				
			preg_match_all('/('.implode('|', $attributes).')=("[^"]*")/i', str_replace('\'', '"', $tag), $matches);
			
			foreach ($matches[1] as $id => $key) {
				
				$result[$key] = str_replace('"', '', $matches[2][$id]);
			}
			
			return $result;
		}

	endif;

	/**
	 * Returns the content within a html tag
	 *
	 * @return array
	 */
	
	if (! function_exists('return_html_content')) :

		function return_html_content($html, $tag = null) {
			
			if (empty($tag)) {
			
				$matching = preg_match_all('/(<.*>)(.*)(<\/.*>)/imxsU', $html, $match);
				$result = empty($matching) ? '' : $match[2][0];
			}
			else {
				
				$matching = preg_match('/<'.$tag.'[^>]*>(.*?)<\/'.$tag.'>/si', $html, $match);
				$result = empty($matching) ? '' : $match[1];
			}
			
			return $result;
		}

	endif;

	/**
	 * Returns a string with all data attributes
	 *
	 * @return string
	 */
	
	if (! function_exists('return_data_attributes')) :

		function return_data_attributes($html, $tag = null) {
			
			preg_match_all('/(data[-?a-zA-Z0-9]*)=("[^"]*")/i', str_replace('\'', '"', $tag), $matches);
		
			return implode(' ', $matches[0]);
		}

	endif;

	/**
	 * Returns an array with all data attributes
	 *
	 * @return array
	 */
	
	if (! function_exists('return_data_attributes_values')) :

		function return_data_attributes_values($html, $tag = null) {

			$result = array();
		
			preg_match_all('/(data[-?a-zA-Z0-9]*)=("[^"]*")/i', str_replace('\'', '"', $tag), $matches);
			
			foreach ($matches[1] as $id => $key) {
				
				$result[$key] = str_replace('"', '', $matches[2][$id]);
			}
			
			return $result;
		}

	endif;

	/**
	 * Returns all href attributes from a html string
	 *
	 * @return string
	 */
	
	if (! function_exists('return_all_href_attributes')) :

		function return_all_href_attributes($html, $tag = null) {
			
			$matching = preg_match_all('~href=("|\')(.*?)\1~', $html, $match);
			$result = empty($matching) ? '' : $match[2];		
			
			return $result;
		}

	endif;

	/**
	 * Returns an URL with the correct start prefix
	 *
	 * @return string
	 */
	
	if (! function_exists('get_external_url')) :

		function get_external_url($url) {
			
			if (substr($url, 0, 1) === '#') { $path = $url; } else { $path = preg_match('#^http(s)?://#i', $url) ? $url : site_url(); }
			
			return $path;
		}

	endif;

	/**
	 * Returns the upload file path of an image
	 *
	 * @return string
	 */
	
	if (! function_exists('get_file_path')) :

		function get_file_path($id) {
			
			$path = wp_upload_dir();
			$file = get_post_meta($id, '_wp_attached_file', true);
			$file = $path['basedir'].'/'.$file;

			return $file;
		}

	endif;

	/**
	 * Returns the image ratio of an image
	 *
	 * @return number
	 */
	
	if (! function_exists('get_image_ratio')) :

		function get_image_ratio($file) {
			
			$size = empty($file) || ! file_exists($file) ? '' : getimagesize($file);
			$ratio = isset($size[0]) ? $size[0] / $size[1] : 2;

			return $ratio;
		}

	endif;
	
	/**
	 * Creates a comma separated list of items using the Oxford comma notation
	 *
	 * @param $array 		- array with list items
	 * @param $separator	- string
	 *
	 * @return string
	 */

	if (! function_exists('get_comma_separated_list')) :

		function get_comma_separated_list($array, $separator = 'and') {
	        
			$string = implode(' '.$separator.' ', array_filter(array_reverse(array_merge(array(array_pop($array)), array(implode(', ', $array))))));
			
	        return $string;
	    }

    endif;

    /**
	 * Returns an array from string input
	 *
	 * @param $input 	- string of comma or space separated content
	 *
	 * @return array
	 */

    if (! function_exists('convert_string_to_array')) :

		function convert_string_to_array($input) {
			
			if (empty($input)) {
				
				$output = '';		
			}
			else {

				$string = str_replace(array(',', ';'), '', preg_replace('/[\t\n\r\0\x0B]/', ' ', preg_replace('/\s+/', ' ', trim($input))));
				$output = array_map('trim', explode(' ', $string));
			}
			
			return $output;
		}
		
	endif;

    /**
	 * returns random numbers from an array
	 *
	 * @param $min 			- min number
	 * @param $max 			- max number
	 * @param $quantity		- amount of numbers to return
	 *
	 * @return array
	 */

	if (! function_exists('get_random_number')) :

		function get_random_number($min, $max, $quantity) {
	        
			$numbers = range($min, $max);
    		shuffle($numbers);
    		
    		return array_slice($numbers, 0, $quantity);
	    }

    endif;
    
    /**
	 * Shortens a text to the specified amount of characters
	 *
	 * @param $string 	- string of HTML
	 * @param $max		- integer of how many characters the result will be
	 *
	 * @return string
	 */

    if (! function_exists('get_text_excerpt')) :

		function get_text_excerpt($string, $max = 240) {
			
			$max = empty($max) ? 240 : $max;
			$max = is_array($max) ? $max[0] : $max;
			
			$string = preg_replace('/<\/(.+?)>/', '</$1> &nbsp;', $string);
			$string = strip_shortcodes($string);
			$string = strip_tags($string);
			$string = str_replace('&nbsp;', ' ', $string);
			$string = str_replace('&lt;!--more--&gt;', ' ', $string);
			$string = preg_replace('/[\t\n\r\0\x0B]/', '', $string);
	    	$string = preg_replace('/([\s])\1+/', ' ', $string);
	    	$string = trim($string);

			$text = substr($string, 0, $max);
			$text .= strlen($string) > $max ? '...' : '';
			
			return $text;
		}
		
	endif;

	/**
	 * Checks if the string contains an email and obfuscates it
	 *
	 * @param $text 	- string of email
	 *
	 * @return string
	 */

    if (! function_exists('obfuscate_email')) :

		function obfuscate_email($text) {
			
			if (preg_match_all("/([a-zA-Z0-9_\.\-]+)@([a-zA-Z0-9\-]+)\.([a-zA-Z0-9\-\.]*)/i", $text, $matches)) {
							
				$text = $matches['1']['0'].'&#x40;'.$matches['2']['0'].'&#x002E;'.$matches['3']['0'];
			}
			
			return $text;
		}
		
	endif;

	/**
	 * Adds required gooogle map script to the footer
	 *
	 * @return string $html
	 */

	if (! function_exists('add_google_map_js')) :

        function add_google_map_js() {
            
            echo '<script src="https://maps.googleapis.com/maps/api/js?key='.GOOGLE_API_KEY.'&amp;language=en"></script>'."\n";
            
        }

    endif;

?>