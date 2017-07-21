<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Generates an image gallery from the [gallery] shortcode

	class Gallery {
		
		
		public function __construct() {
						
			add_action('init', array($this, 'init'));
		}

		/**
		 * Registers a hook into wp init
		 *
		 */

		public function init() {

			remove_shortcode('gallery', 'gallery_shortcode');
			add_shortcode('gallery', array($this, 'gallery_shortcode'));
		}

		/**
		 * Builds the gallery shortcode output
		 *
		 * @param $attr 	- array with gallery attributes
		 *
		 * @return string $html
		 */

		public static function gallery_shortcode($attr) {

			static $instance = 0;

			$post = get_post();
			$instance ++;
			$output = '';
			$i = 0;

			if (! empty( $attr['ids'])) { 

				$attr['include'] = $attr['ids'];
				$attr['orderby'] = empty($attr['orderby']) ? 'post__in' : $attr['orderby'];
				$attr['link'] = empty($attr['link']) ? 'post' : $attr['link'];
			}

			$atts = shortcode_atts(array(

				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post ? $post->ID : 0,
				'itemtag'    => 'figure',
				'icontag'    => 'div',
				'captiontag' => 'figcaption',
				'columns'    => 3,
				'size'       => 'thumbnail',
				'style'      => '',
				'include'    => '',
				'exclude'    => '',
				'link'       => ''

			), $attr, 'gallery');

			// fetching the attachments

			if (! empty( $atts['include'])) {
				
				$_attachments = get_posts(array('include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby']));
				$attachments = array();

				foreach ($_attachments as $key => $val) { $attachments[$val->ID] = $_attachments[$key]; }
			}
			elseif (! empty($atts['exclude'])) {

				$attachments = get_children(array('post_parent' => intval($atts['id']), 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby']));
			}
			else {

				$attachments = get_children(array('post_parent' => intval($atts['id']), 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby']));
			}

			// building the gallery

			if (! empty($attachments)) {

				if (is_feed()) {

					foreach ($attachments as $att_id => $attachment) {
						
						$output .= wp_get_attachment_link($att_id, $atts['size'], true)."\n";
					}
				}
				else {
					
					$size = $atts['size'];
					$style = empty($atts['style']) ? '' : $atts['style'];

					$gallery = $atts['link'] === 'file' ? ' image-gallery' : '';
					$class = empty($style) ? 'gallery'.$gallery.' columns-'.intval($atts['columns']) : 'mosaic'.$gallery;

					$output .= "\n";
					$output .= '<ul class="'.$class.'">'."\n";

					foreach ($attachments as $id => $attachment) {

						$meta = wp_get_attachment_metadata($id);
						$thumbnail = wp_get_attachment_image_src($id, $size);

						$loader = esc_url(get_template_directory_uri()).'/img/img-loader.png';

						$caption = htmlspecialchars(get_text_excerpt($attachment->post_excerpt), 9999);
						$alt = get_post_meta($id, '_wp_attachment_image_alt', true);

						$width = $thumbnail[1];
    					$height = $thumbnail[2];

						$image = '<img src="'.$loader.'" data-srcset="'.$thumbnail[0].' 1x, '.$thumbnail[0].' 2x" class="lazyload" width="'.$width.'" height="'.$height.'" alt="'.(empty($alt) ? $caption : $alt).'" />';

						if ($atts['link'] === 'file') {

							$output .= empty($style) ? "\t".'<li><a href="'.wp_get_attachment_image_url($id, 'large').'" data-rel="gallery" rel="nofollow" title="'.$caption.'">'.$image.'</a></li>'."\n" : "\t".'<li><figure class="cover-photo unveil"><a href="'.wp_get_attachment_image_url($id, 'large').'" data-rel="gallery" rel="nofollow" title="'.$caption.'">'.$image.'</a></figure></li>'."\n";
						}
						elseif ($atts['link'] === 'post') {

							$output .= empty($style) ? "\t".'<li><a href="'.get_attachment_link($id).'" rel="nofollow" title="'.$caption.'">'.$image.'</a></li>'."\n" : "\t".'<li><figure class="cover-photo unveil"><a href="'.get_attachment_link($id).'" rel="nofollow" title="'.$caption.'">'.$image.'</a></figure></li>'."\n";
						}
						else {

							$output .= empty($style) ? "\t".'<li>'.$image.'</li>'."\n" : "\t".'<li><figure class="cover-photo unveil">'.$image.'</figure></li>'."\n";
						}
					}
					
					$output .= '</ul>'."\n";
				}
			}

			return $output;
		}
	}

	new Gallery();
?>