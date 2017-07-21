<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Hooks to cleanup output of post and page content

	class Content {
		
		public function __construct() {

			add_action('init', array($this, 'init'));
		}

		/**
		 * Registers a hook into wp init
		 *
		 */

		public function init() {

			add_filter('the_content', array($this, 'remove_empty_paragraphs'), 10, 1);
			add_filter('the_content', array($this, 'remove_line_breaks'), 10, 1);
			add_filter('the_content', array($this, 'remove_wrapping_paragraphs'), 10, 1);
			add_filter('the_content', array($this, 'content_image'), 10, 1);
			add_filter('img_caption_shortcode', array($this, 'content_figcaption'), 10, 3);
		}

		/**
		 * Filters empty paragraph elements and removes them
		 *
		 * @param $content 	- the raw post content to be filtered
		 *
		 * @return string $html
		 */

		public static function remove_empty_paragraphs($content) {

			$content = force_balance_tags($content);
			$content = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
			$content = preg_replace('~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content);

			return $content;
		}

		/**
		 * Filters empty paragraph elements and removes them
		 *
		 * @param $content 	- the raw post content to be filtered
		 *
		 * @return string $html
		 */

		public static function remove_wrapping_paragraphs($content) {

			$content = preg_replace('/<p>\\s*?(<a.*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '$1', $content);
			$content = preg_replace_callback('/<p.*?>(.+?)<\\/p>/', function($match) { return str_replace('<p></p>', '', preg_replace('/(<a.*?><img.*?><\\/a>|<img.*?>)/i', '</p>$1'."\n".'<p>', $match[0])); }, $content);

			return $content;
		}		

		/**
		 * Filters line breaks (<br>) and replaces them with a paragraph
		 *
		 * @param $content 	- the raw post content to be filtered
		 *
		 * @return string $html
		 */

		public static function remove_line_breaks($content) {

			$content = preg_replace_callback('#\<p\>(.+?)\<\/p\>#s', function($match) { return preg_replace('/[\t\n\r\0\x0B]/', '', $match[0]); }, $content);
			$content = preg_replace('#<br\s*/?>#i', '</p><p>', $content);
			$content = preg_replace('(<h([1-6])>)', "\n".'<h$1>', $content);
			$content = str_replace('</p><p>', '</p>'."\n".'<p>', $content);

			return $content;
		}

		/**
		 * Filters figure elements and removes unwanted attributes
		 *
		 * @param $content 	- the raw post content to be filtered
		 *
		 * @return string $html
		 */

		public static function content_figcaption($output, $attr, $content = null) {

			$figure = '';

			$class = empty($attr['align']) ? '' : ' class="'.str_replace('align', 'align-', $attr['align']).'"';

			$figure .= '<figure'.$class.'>';
			$figure .= $content;
			$figure .= '<figcaption>'.get_text_excerpt($attr['caption'], 9999).'</figcaption>';
			$figure .= '</figure>';

			return $figure;
		}

		/**
		 * Filters image elements in post content to add additional attributes
		 *
		 * @param $content 	- the raw post content to be filtered
		 *
		 * @return string $html
		 */

		public static function content_image($content) {

			if (! preg_match_all('/<a.*?><img.*?><\\/a>|<img.*?>/', $content, $matches)) {
				
				return $content;
			}

			$temp = $keys = array();

			foreach($matches[0] as $image) {

				if (preg_match('/wp-image-([0-9]+)/i', $image, $class_id) && $id = absint($class_id[1])) {

					$temp[$image] = $id;
					$keys[$id] = true;
				}
			}

			if (count($keys) > 1) {

				update_meta_cache('post', array_keys($keys));
			}

			foreach ($temp as $image => $id) {

				$meta = get_post_meta($id, '_wp_attachment_metadata', true);
				$content = str_replace($image, self::content_image_tag($image, $id, $meta), $content);
			}

			return $content;
		}

		/**
		 * Returns the anchor element of an embeded image
		 *
		 * @param $$match 	- matched html string of an image with an anchor
		 *
		 * @return string $html
		 */

		public static function content_image_anchor($match) {

			$image = $match[1];
			$href = preg_match('/href="([^"]+)"/', $match[0], $href) ? $href[0] : '';
			$preview = preg_match('~\b(jpg|jpeg|gif|png)\b~i', $href, $preview) ? $preview[0] : '';
						
			$data = empty($preview) ? '' : ' data-action="image"';
			$data .= ' rel="nofollow"';
			$target = get_target_attribute($href);

			$anchor = '<a '.$href.''.$target.''.$data.'>'.$image.'</a>';

			return $anchor;
		}

		/**
		 * Returns the class name an embeded image
		 *
		 * @param $image 	- html string of the image
		 *
		 * @return string
		 */

		public static function content_image_class($image) {

			$class = preg_match('/class="([^"]+)"/', $image, $match) ? $match[1] : '';
			$match = preg_match('~\b(alignleft|aligncenter|alignright)\b~i', $class, $match) ? $match[0] : '';

			switch ($match) {

				case 'alignleft':

					$class = ' class="align-left"';

				break;
				case 'aligncenter':

					$class = ' class="align-center"';

				break;
				case 'alignright':

					$class = ' class="align-right"';

				break;
				default:

					$class = '';

				break;
			}

			return $class;
		}

		/**
		 * Returns the HTML tag of an embeded image
		 *
		 * @param $image 	- html string of the image
		 * @param $id 		- attachment ID string
		 * @param $meta 	- array with attachment meta information
		 *
		 * @return string $html
		 */

		public static function content_image_tag($image, $id, $meta) {

			$src = preg_match('/src="([^"]+)"/', $image, $src) ? $src[1] : '';
			$alt = preg_match('/alt="([^"]+)"/', $image, $alt) ? $alt[1] : '';

			$image = preg_replace_callback('/<a.*?>\\s*?(<img.*?>)?\\s*<\\/a>/s', array(__CLASS__, 'content_image_anchor'), $image);
			$image = '<figure'.self::content_image_class($image).'>'.$image.'</figure>';

			list($src) = explode('?', $src);

			// Return early if we couldn't get the image source

			if (! $src) {

				return $image;
			}

			// Return early if an image has been inserted and later edited

			if (isset($meta['file']) && preg_match( '/-e[0-9]{13}/', $meta['file'], $hash) && strpos(wp_basename($src), $hash[0]) === false) {

				return $image;
			}

			$class = '';
			$max_width = '796';
			$maxh_height = '448';

			$width = preg_match('/ width="([0-9]+)"/',  $image, $width) ? (int) $width[1]  : $max_width;
			$height = preg_match('/ height="([0-9]+)"/', $image, $height) ? (int) $height[1] : $maxh_height;
			
			$ratio = $width / $height;

			if ($width >= $max_width) {

				$width = $max_width;
				$height = round($width / $ratio);
			}
			
			$output = preg_replace("/<img[^>]+\>/i", '<img src="'.$src.'" class="'.$class.'" width="'.$width.'" height="'.$height.'" alt="'.$alt.'" />', $image);

			return $output;
		}
	}

	new Content();
?>