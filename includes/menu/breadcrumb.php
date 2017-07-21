<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	global $wp_query;
	
	$prefix = '';
	$type = is_front_page() ? 'home' : get_page_type();
	$template = get_current_page_template();
	$class = 'breadcrumb';

	switch ($template) {
		case 'forum':
			
			$title = get_theme_option('forum_options', 'forum_title');

			$root = empty($title) ? __('Forum', 'theme translation') : $title;
			$root_url = class_exists('bbPress') ? bbp_get_forums_url() : get_site_url();
								
		break;
		case 'single':
		case 'category':
		case 'author':
		case 'archive':
		case 'tag':
						
			$root = __('Blog', 'theme translation');
			$root_url = get_site_url();
		
		break;
		case 'search':
							
			$root = __('Home', 'theme translation');
			$prefix = __('Search: ', 'theme translation');
			$root_url = get_site_url();
								
		break;
		default:
		
			$root = __('Home', 'theme translation');
			$root_url = get_site_url();
		
		break;
	}
	
	if ($type == 'home') {
		
		$breadcrumb = '';
			
		$breadcrumb .= '<!-- breadcrumb starts -->'."\n";
		$breadcrumb .= "\t".'<nav class="'.$class.'" role="navigation">'."\n";
		$breadcrumb .= "\t\t".'<ol vocab="http://schema.org/" typeof="BreadcrumbList">'."\n";
		$breadcrumb .= "\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.$root_url.'" property="item" typeof="WebPage" title="'.$root.'"><span property="name">'.$root.'</span><meta property="position" content="1"></a></li>'."\n";
		$breadcrumb .= "\t\t".'</ol>'."\n";
		$breadcrumb .= "\t".'</nav>'."\n";
		$breadcrumb .= '<!-- breadcrumb ends -->'."\n";
		
		echo null;
	}
	else {

		$breadcrumb = new MenuOptions\Build;
		$breadcrumb = $breadcrumb->html(array('walker' => new MenuOptions\Breadcrumb(), 'menu' => 'Page menu', 'class' => $class, 'prefix' => '', 'id' => '', 'level' => 0, 'depth' => 0, 'container' => 'ol', 'schema' => 'BreadcrumbList'));

		if (empty($breadcrumb)) {
			
			$query = $wp_query->get_queried_object();
			$url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			
			if (isset($query->name)) { $current = $query->name; } else { if (is_search()) { $current = ucfirst(stripslashes(strip_tags(get_search_query()))); } else if (is_date()) { $current = get_page_title(); } else if (is_author()) { $author = get_the_author_meta('user_firstname').' '.get_the_author_meta('user_lastname'); $current = empty(trim($author)) ? get_the_author_meta('nickname') : $author; } else { $current = trim(wp_title('', false, '')); } }
			
			$breadcrumb = '';
			
			$breadcrumb .= '<!-- breadcrumb starts -->'."\n";
			$breadcrumb .= "\t".'<nav class="'.$class.'" role="navigation">'."\n";
			$breadcrumb .= "\t\t".'<ol vocab="http://schema.org/" typeof="BreadcrumbList">'."\n";

			if ($template === 'forum' && class_exists('bbPress')) {

				$forum_url = bbp_get_forums_url();
				$current_url = get_current_page_url();

				if ($current_url === $forum_url) {

					$breadcrumb .= "\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.get_site_url().'" property="item" typeof="WebPage" title="'.__('Home', 'theme translation').'"><span property="name">'.__('Home', 'theme translation').'</span><meta property="position" content="1"></a></li>'."\n";
					$breadcrumb .= "\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.$root_url.'" property="item" typeof="WebPage" title="'.$root.'"><span property="name">'.$root.'</span><meta property="position" content="2"></a></li>'."\n";
				}
				else {

					$breadcrumb .= "\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.get_site_url().'" property="item" typeof="WebPage" title="'.__('Home', 'theme translation').'"><span property="name">'.__('Home', 'theme translation').'</span><meta property="position" content="1"></a></li>'."\n";
					$breadcrumb .= "\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.$root_url.'" property="item" typeof="WebPage" title="'.$root.'"><span property="name">'.$root.'</span><meta property="position" content="2"></a></li>'."\n";
					$breadcrumb .= "\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.$url.'" property="item" typeof="WebPage" title="'.$prefix.''.$current.'"><span property="name">'.$prefix.''.ucfirst($current).'</span><meta property="position" content="3"></a></li>'."\n";
				}
			}
			else {

				$breadcrumb .= "\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.$root_url.'" property="item" typeof="WebPage" title="'.$root.'"><span property="name">'.$root.'</span><meta property="position" content="1"></a></li>'."\n";
				$breadcrumb .= "\t\t\t".'<li property="itemListElement" typeof="ListItem"><a href="'.$url.'" property="item" typeof="WebPage" title="'.$prefix.''.$current.'"><span property="name">'.$prefix.''.$current.'</span><meta property="position" content="2"></a></li>'."\n";
			}

			$breadcrumb .= "\t\t".'</ol>'."\n";
			$breadcrumb .= "\t".'</nav>'."\n";
			$breadcrumb .= '<!-- breadcrumb ends -->'."\n";
			
			echo $breadcrumb;
		}
		else {
			
			echo $breadcrumb;
		}
	}

?>
