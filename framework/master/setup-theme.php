<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016
	
		
	/**
	* Sets up theme defaults and registers support for various WordPress features.
	*
	*/

	if (! function_exists('setup_theme_defaults') ) :

		function setup_theme_defaults() {

			// Make theme available for translation
	
			load_theme_textdomain('theme translation', get_template_directory() . '/translation');
			load_theme_textdomain('admin translation', get_template_directory() . '/translation');

			// Enable support for certain theme features (https://codex.wordpress.org/Function_Reference/add_theme_support)

			add_theme_support('html5', array('comment-list', 'search-form', 'comment-form', 'gallery', 'caption'));
			add_theme_support('post-formats', array('aside','image','video','quote','link','gallery'));

			// Activates the link manager, which has been removed in wordpress 3.5
	
			add_filter('pre_option_link_manager_enabled', '__return_true');
			
			// Adds theme styling to the TinyMCE visual editor

			add_editor_style(THEME_ASSETS.'/fonts/fonts.css');
			add_editor_style(THEME_ADMIN_ASSETS.'/css/admin-editor.css');
		}

	endif;
	add_action('after_setup_theme', 'setup_theme_defaults');
	
	/**
	* Hides admin menu items that a certain user role should not access
	*
	*/

	if (! function_exists('admin_menu_access_rights') ) :
		
		function admin_menu_access_rights() {

			$user = new WP_User(get_current_user_id());
			$role = isset($user->roles[0]) ? $user->roles[0] : '';

			if ($role === 'author' || $role === 'editor') {

				global $submenu;

				unset($submenu['themes.php'][5]);
				unset($submenu['themes.php'][6]);
			}
		}

	endif;
	add_action('admin_menu', 'admin_menu_access_rights');

	/**
	* Includes stylesheet or javascript files that are required in admin, i.e. if they are not already included
	*
	*/

	if (! function_exists('admin_enqueue_theme_scripts') ) :
		
		function admin_enqueue_theme_scripts() {

			wp_enqueue_style('admin-style', THEME_ADMIN_ASSETS.'/css/admin.css', array('thickbox', 'colors', 'farbtastic'), false, 'all');
			wp_enqueue_script('js-admin', THEME_ADMIN_ASSETS.'/js/admin.min.js', array('jquery', 'media-upload', 'thickbox', 'postbox', 'wp-ajax-response', 'wp-lists', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-datepicker', 'jquery-ui-sortable', 'farbtastic', 'link', 'xfn'), false, true);
		}

	endif;
	add_action('admin_enqueue_scripts', 'admin_enqueue_theme_scripts');

	/**
	* Redirects a page if the SEO field for a 301 redirect is used
	*
	*/

	if (! function_exists('page_301_redirect') ) :
		
		function page_301_redirect() {

			global $post;

			if (is_singular() && isset($post)) {

				$url = get_post_meta($post->ID, 'redirect_url', true);
				if (!empty($url)) { wp_redirect(get_external_url($url), 301); exit; }
			}
		}

	endif;
	add_action('wp', 'page_301_redirect');

	/**
	* Registers required settings for custom fields and meta boxes
	*
	*/

	if (! function_exists('register_custom_theme_settings') ) :

		function register_custom_theme_settings() {

			add_option(THEME_NAME.'_error_tracking', '', '', 'yes');
			add_option(THEME_NAME.'_uploaded_form_content', '', '', 'yes');
			add_option(THEME_NAME.'_updated_meta', '', '', 'yes');
		}

	endif;
	add_action('after_switch_theme', 'register_custom_theme_settings');
	
	/**
	* Changes the position of featured image box
	*
	*/

	if (! function_exists('reposition_image_box') ) :

		function reposition_image_box() {

			remove_meta_box('postimagediv', 'customposttype', 'side');
			add_meta_box('postimagediv', __('Custom Image'), 'post_thumbnail_meta_box', 'customposttype', 'normal', 'high');
		}

	endif;
	add_action('do_meta_boxes', 'reposition_image_box');
	
	/**
	* Sets up default theme options and register its settings in WordPress.
	*
	*/

	if (! function_exists('setup_theme_options') ) :

		function setup_theme_options() {

			// Sets default values under WordPress setting options

			$options = array(
				
				'use_smilies'               => 0,
				'thumbnail_size_w'			=> 300,
				'thumbnail_size_h'			=> 300,
				'medium_size_w'				=> 600,
				'medium_size_h'				=> 600,
				'large_size_w'				=> 1200,
				'large_size_h'				=> 1200,
				'category_base'             => '',
				'default_comment_status'	=> 'closed',
				'default_ping_status'       => 'closed',
				'comments_per_page'         => 0,
				'comment_max_links'         => 0,
				'permalink_structure'       => '/%category%/%postname%/',
				'image_default_link_type'	=> 'none',
				'image_default_size'		=> 'full'
			);
			
			foreach ($options as $key => $value) update_option($key, $value);

			// Flushes the internal cache to make sure default settings are registered
			
			flush_rewrite_rules();
		}

	endif;
	add_action('after_switch_theme', 'setup_theme_options');

	/**
	* Loops through all published posts and adds a meta description value
	*
	* @return it will only run once, when the theme is activated
	* @remark it can be removed after the theme is initialized
	* 
	*/

	if (! function_exists('update_meta_description') ) :

		function update_meta_description() {

			$updated = get_option(THEME_NAME.'_updated_meta');

			if (!is_admin()) {
				
				if ($updated != true) {

					$args = array('post_type' => 'post', 'orderby' => 'title', 'order' => 'DESC', 'posts_per_page' => 99999);
					$wp_query = new WP_Query($args);

					foreach ($wp_query->posts as $key => $post) {
						
						$excerpt = get_text_excerpt($post->post_content, 142);
						$description = empty($excerpt) ? $post->post_title : utf8_encode($excerpt);

						update_post_meta($post->ID, 'meta_description', $description);

						update_post_meta($post->ID, 'facebook_title', $post->post_title);
						update_post_meta($post->ID, 'facebook_description', $description);

						update_post_meta($post->ID, 'twitter_title', $post->post_title);
						update_post_meta($post->ID, 'twitter_description', $description);
					}

					update_option(THEME_NAME.'_updated_meta', true);
				}
			}
		}

	endif;
	add_action('after_switch_theme', 'update_meta_description');

	/**
	* Includes needed theme functions and classes
	*
	*/

	include_once( get_template_directory() . '/framework/master/functions/functions.php' );
	include_once( get_template_directory() . '/framework/master/libraries/content.php' );
	include_once( get_template_directory() . '/framework/master/libraries/gallery.php' );
	include_once( get_template_directory() . '/framework/master/libraries/image.php' );
	include_once( get_template_directory() . '/framework/master/libraries/media.php' );
	include_once( get_template_directory() . '/framework/master/libraries/pagination.php' );
	include_once( get_template_directory() . '/framework/master/libraries/popular.php' );
	include_once( get_template_directory() . '/framework/master/libraries/post.php' );
	include_once( get_template_directory() . '/framework/master/libraries/sitemap.php' );
	include_once( get_template_directory() . '/framework/master/libraries/tinymce.php' );
	include_once( get_template_directory() . '/framework/master/libraries/bbpress.php' );

	/**
	* Includes needed template files for form input fields
	*
	*/

	include_once( get_template_directory() . '/framework/master/templates/fields/action.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/checkbox.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/color.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/file.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/font.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/font-preview.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/gmap.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/image.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/input-list.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/hidden.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/matrix.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/media.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/number.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/phone.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/radio.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/radio-option.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/select.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/select-list.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/seo.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/text.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/textarea.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/trigger.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/trigger-button.php' );
	include_once( get_template_directory() . '/framework/master/templates/fields/url.php' );

	/**
	* Includes needed class files for form validation
	*
	*/
	
	include_once( get_template_directory() . '/framework/master/validation/classes/color.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/file.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/image.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/input-list.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/matrix.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/media.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/multiselect.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/number.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/phone.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/trigger.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/url.php' );

	/**
	* Includes custom class files for form validation
	*
	*/

	include_once( get_template_directory() . '/framework/master/validation/classes/custom/generate-xml-sitemap.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/preserve-default-value.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/prevent-empty-number.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/prevent-empty-value.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/remove-html-special-chars.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/run-flush-rewrite-rules.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/set-article-reading-time.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/validate-facebook-id.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/validate-twitter-username.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/verify-email.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/verify-email-list.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/verify-gmap-location.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/verify-google-analytics-code.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/verify-meta-keywords.php' );
	include_once( get_template_directory() . '/framework/master/validation/classes/custom/verify-verification-code.php' );
	
	/**
	* Includes core framework files to setup custom theme options
	*
	*/

	include_once( get_template_directory() . '/framework/master/templates/field.php' );
	include_once( get_template_directory() . '/framework/master/validation/validation.php' );

	include_once( get_template_directory() . '/framework/master/settings/widget/build.php' );
	include_once( get_template_directory() . '/framework/master/settings/widget/register.php' );
	include_once( get_template_directory() . '/framework/master/settings/widget/functions.php' );

	include_once( get_template_directory() . '/framework/master/settings/theme/build.php' );
	include_once( get_template_directory() . '/framework/master/settings/theme/register.php' );
	include_once( get_template_directory() . '/framework/master/settings/theme/save.php' );
	include_once( get_template_directory() . '/framework/master/settings/theme/functions.php' );

	include_once( get_template_directory() . '/framework/master/settings/taxonomy/build.php' );
	include_once( get_template_directory() . '/framework/master/settings/taxonomy/register.php' );
	include_once( get_template_directory() . '/framework/master/settings/taxonomy/save.php' );

	include_once( get_template_directory() . '/framework/master/settings/post-type/build.php' );
	include_once( get_template_directory() . '/framework/master/settings/post-type/register.php' );
	include_once( get_template_directory() . '/framework/master/settings/post-type/register-taxonomy.php' );
	
	include_once( locate_template(           '/framework/master/settings/menus/walkers/breadcrumb.php') );
	include_once( get_template_directory() . '/framework/master/settings/menus/walkers/dropdown.php' );
	include_once( locate_template(           '/framework/master/settings/menus/walkers/navigation.php') );

	include_once( locate_template(           '/framework/master/settings/menus/build.php') );
	include_once( get_template_directory() . '/framework/master/settings/menus/register.php' );

	include_once( get_template_directory() . '/framework/master/settings/metabox/build.php' );
	include_once( get_template_directory() . '/framework/master/settings/metabox/register.php' );
	include_once( get_template_directory() . '/framework/master/settings/metabox/save.php' );

	include_once( get_template_directory() . '/framework/master/settings/user/build.php' );
	include_once( get_template_directory() . '/framework/master/settings/user/register.php' );
	include_once( get_template_directory() . '/framework/master/settings/user/save.php' );

?>