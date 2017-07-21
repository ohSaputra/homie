<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Generates custom content for a blog post

	class Post {

		private	$post;
		
		public function __construct($post) {
			
			$this->post = $post;
		}

		/**
		 * Returns a post title based on theme settings
		 *
		 * @return string
		 */

		public function title($max = '') {
			
			$output = '';

			$max = isset($max) && $max != '' ? $max : get_theme_option('blog_options', 'title_excerpt_length');

			$output = get_text_excerpt(htmlspecialchars($this->post->post_title), $max);

			return $output;
		}
		
		/**
		 * Returns a post excerpt based on theme settings
		 *
		 * @return string
		 */

		public function text($max = '') {
			
			$output = '';

			$style = get_theme_option('blog_options', 'post_excerpt');
			$max = isset($max) && $max != '' ? $max : get_theme_option('blog_options', 'post_excerpt_length');

			if ($style === '2') {

				$output = get_the_excerpt();
			}
			else {

				$output = get_text_excerpt(strip_shortcodes($this->post->post_content), $max);
			}

			return $output;
		}

		/**
		 * Returns various date formats about a post date
		 *
		 * @return array
		 */

		public function date() {

			$output = '';

			$output['date'] = mysql2date(get_option('date_format'), $this->post->post_date);
			$output['time'] = mysql2date(get_option('time_format'), $this->post->post_date);
			$output['posted'] = sprintf(__('Posted %1$s at %2$s', 'theme translation'), mysql2date(get_option('date_format'), $this->post->post_date), mysql2date(get_option('time_format'), $this->post->post_date));
			$output['datetime'] = mysql2date('c', $this->post->post_date);

			return $output;
		}

		/**
		 * Returns a time tag
		 *
		 * @return string $html
		 */

		public function time() {

			$date = $this->date();
			$output = '<time class="post-date" datetime="'.$date['datetime'].'" title="'.$date['posted'].'">'.$date['date'].'</time>'."\n";

			return $output;
		}

		/**
		 * Returns a comment link element
		 *
		 * @return array
		 */

		public function comments() {
						
			$output =  '';
			$total = get_comments_number();
			
			$output['label'] = __('Show Comments', 'theme translation');
			$output['link'] = $total >= 1 ? ($total == 1 ? sprintf(__('%s Comment', 'theme translation'), get_comments_number()) : sprintf(__('%s Comments', 'theme translation'), get_comments_number())) : __('No Comments', 'theme translation');
			$output['url'] = get_permalink().'#comments';
			$output['total'] = $total;

			return $output;
		}

		/**
		 * Returns a post categories
		 *
		 * @return string $html
		 */

		public function categories($separator = ', ', $class = '') {
			
			$output = '';

			$list = '';
			$categories = get_the_category();
			$count = count($categories);
			$class = empty($class) ? '' : ' class="'.$class.'"';
			
			foreach ($categories as $key => $category) {
				
				$short_name = get_term_meta($category->term_id, 'short_name', true);
				
				$name = empty($short_name) ? $category->name : $short_name;
				
				$list .= '<a href="'.esc_url(get_category_link($category->term_id)).'"'.$class.' rel="category tag" title="'.sprintf(__('View all posts in %s', 'theme translation'), $category->name).'">'.$name.'</a>';
				$list .= $count == $key + 1 ? '' : $separator;
			}

			$output['list'] = $list;
			$output['count'] = $count;

			return $output;
		}

		/**
		 * Returns a post author information
		 *
		 * @return array
		 */

		public function author() {
			
			$output = array();

			$author = $this->post->post_author;
			
			$output['id'] = $author;
			$output['nicename'] = get_the_author_meta('nickname', $author);
			$output['name'] = get_the_author_meta('user_firstname', $author).' '.get_the_author_meta('user_lastname', $author);
			$output['url'] = get_author_posts_url($author);
			$output['description'] = get_the_author_meta('description', $author);
			
			return $output;
		}

		/**
		 * Returns a post author avatar information
		 *
		 * @return array
		 */

		public function avatar($size = 80) {

			$avatar = get_avatar(get_the_author_meta('user_email'), $size, '', get_the_author_meta('user_firstname').' '.get_the_author_meta('user_lastname'));
			$output = return_html_attributes($avatar);

			return $output;
		}

		/**
		 * Returns the link label for a post entry
		 *
		 * @return string
		 */

		public function label() {
			
			$option = get_theme_option('blog_options', 'post_link_option');

			switch ($option) {
				case '1':
				
					$output = __('Read more', 'theme translation');
					
				break;
				case '2':
				
					$output = __('Continue reading', 'theme translation');
					
				break;
				case '3':
				
					$output = __('See full article', 'theme translation');
					
				break;
				case '4':
				
					$output = __('Read this post', 'theme translation');
					
				break;
				case '5':
				
					$output = __('Learn more', 'theme translation');
					
				break;
				default:
				
					$output = empty($list_link) ? __('Read more', 'theme translation') : $list_link;
					
				break;
			}
						
			return $output;
		}

		/**
		 * Returns a post media element
		 *
		 * @return string $html
		 */

		public function media($size = 'large', $alt = '') {
			
			$output = '';
			
			$url = get_permalink($this->post->ID);
			$id = get_post_thumbnail_id($this->post->ID);
			$meta = get_post_meta($id, '_wp_attachment_image_alt', true);

			$title = htmlspecialchars($this->post->post_title);
			
			$alt = empty($alt) ? $meta : $alt;
			$src = get_the_post_thumbnail_url($this->post->ID, $size);

			$file = empty($id) ? '' : get_file_path($id);

			$width = 555;
    		$height = round($width / get_image_ratio($file));
						
			$src = empty($src) ? esc_url(get_template_directory_uri()).'/img/img-default-640x320.png' : $src;
			$loader = esc_url(get_template_directory_uri()).'/img/img-loader.png';
			
			$output = '<figure class="post-figure"><a href="'.$url.'" title="'.$title.'"><img src="'.$loader.'" data-srcset="'.$src.' 1x, '.$src.' 2x" class="lazyload" width="'.$width.'" height="'.$height.'" alt="'.$alt.'" /></a></figure>'."\n";

			return $output;
		}

		/**
		 * Returns a post cover element
		 *
		 * @return string $html
		 */

		public function cover($size = 'large', $alt = '') {

			$output = '';

			$id = get_post_thumbnail_id($this->post->ID);
			$meta = get_post_meta($id, '_wp_attachment_image_alt', true);

			$alt = empty($alt) ? $meta : $alt;
			$src = get_the_post_thumbnail_url($this->post->ID, $size);

			$file = empty($id) ? '' : get_file_path($id);

			$width = 1280;
    		$height = round($width / get_image_ratio($file));
			
			$src = empty($src) ? esc_url(get_template_directory_uri()).'/img/img-default-640x320.png' : $src;
			$loader = esc_url(get_template_directory_uri()).'/img/img-loader.png';

			$output = '<figure class="cover-graphic"><img src="'.$loader.'" data-srcset="'.$src.' 1x, '.$src.' 2x" class="lazyload" width="'.$width.'" height="'.$height.'" alt="'.$alt.'" /></figure>'."\n";

			return $output;
		}

		/**
		 * Returns a post as a card widget
		 *
		 * @param $id 	- id of category displayed
		 *
		 * @return string $html
		 */

		public function card($id = '', $max = '') {
			
			$output = '';
			$max = isset($max) && $max != '' ? $max : get_theme_option('blog_options', 'title_excerpt_length');

			$output .= '<!-- entry starts -->'."\n";
			$output .= "\t".'<section class="blog-card">'."\n";

			$output .= $this->media('post-medium');

			$output .= "\t\t".'<div class="post-data">'."\n";

			if (! empty($id)) {

				$category = get_category($id);

				$output .= "\t\t\t".'<div class="post-meta"><a href="'.get_category_link($id).'" title="'.$category->name.'">'.$category->name.'</a></div>'."\n";
			}
			
			$output .= "\t\t\t".'<h3><a href="'.get_permalink($this->post->ID).'" title="'.$this->label().'">'.get_text_excerpt($this->post->post_title, $max).'</a></h3>'."\n";
			$output .= $this->time();
			$output .= "\t\t".'</div>'."\n";

			$output .= "\t".'</section>'."\n";
			$output .= '<!-- list ends -->'."\n";

			return $output;
		}

		/**
		 * Returns a post's reading time
		 *
		 * @return string
		 */

		public function reading() {

			$reading = get_post_meta($this->post->ID, 'reading_time', true);
			
			if (is_array($reading) && isset($reading['time'])) {

				// if the post have the reading time saved, let's grab it

				$output = $reading['time'];
			}
			else {

				// if the post do not have the reading time, let's generate it and save it

				$post = get_post();

				$words = str_word_count(strip_tags($post->post_content));
				$minutes = floor($words / 120);
				$seconds = floor($words % 120 / (120 / 60));

				if ( 1 <= $minutes ) {
					
					$time = $minutes.' '.__('min.', 'theme translation');
				}
				else {
					
					$time = $seconds.' '.__('sec.', 'theme translation');
				}

				update_post_meta($this->post->ID, 'reading_time', array('words' => $words, 'time' => $time));

				$output = $time;
			}

			return $output;
		}		
	}
?>