<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// SEO preview options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (seo preview)
	// value			= The default value for this field (a value that will be saved in the database at initialisation)
	// settings 		= The settings array of output elements (used to fecth the correct display values)
	// description 		= The description of what this field will do for the user
	//

	class SEO_Field {

		/**
		 * Returns a SEO preview field, but requires output defined in the settings option
		 *
		 * @param $slug 	- string database name
		 * @param $field 	- array with current field settings
		 * @param $value 	- string or array of current field value
		 * @param $options 	- array with optional values ['class'], ['name'], ['id'], ['index']
		 *
		 * @return string $html
		 */

		public static function html($slug, $field, $value, $options = array()) {
				
			$output = '';

			$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
			$term = isset($_REQUEST['taxonomy']) ? $_REQUEST['taxonomy'] : '';
			$settings = isset($field['settings']) ? $field['settings'] : array();
			
			$data = '';
			$company = get_bloginfo('name');
			$tagline = get_bloginfo('description');


			$format = '6';
			$separator = '2';

			$separator = get_theme_option('seo_options', 'page_title_separator');
			$format = get_theme_option('seo_options', 'page_title_format');
						
			if ($term) {
				
				$id = isset($_REQUEST['tag_ID']) ? $_REQUEST['tag_ID'] : 0;
				
				$terms = get_terms($term, array('hide_empty' => 0));
				
				foreach ($terms as $key => $value) {
					
					if ($value->term_id == $id) {
						
						$permalink = get_term_link($value->slug, $term);
						break;
					}
				}
				
				$form = empty($permalink) ? '#addtag' : '#edittag';
				$name_field = empty($permalink) ? 'tag-name' : 'name';
				$permalink = empty($permalink) ? site_url().'/' : $permalink;
			}
			else {
				
				$permalink = get_permalink();
				
				$form = empty($permalink) ? 'form' : '#post';
				$name_field = empty($permalink) ? THEME_NAME.'_title' : 'post_title';
				$permalink = empty($permalink) ? site_url().'/' : $permalink;
			}
			
			foreach ($settings as $key => $value) { $data .= ' data-'.$value[0].'="'.$value[1].'"'; }
			
			$output .= '<div class="seo-preview" id="seo-preview" data-theme="'.THEME_NAME.'" data-form="'.$form.'" data-title="'.htmlspecialchars($name_field).'" data-company="'.$company.'" data-tagline="'.$tagline.'" data-domain="'.site_url().'" data-format-style="'.$format.'" data-separator-style="'.$separator.'" data-alias="'.str_replace(site_url(), '', $permalink).'"'.$data.'>';
			$output .= '<div class="seo-title" title=""></div>';
			$output .= '<div class="seo-url"><cite title=""></cite> - <span>Cached</span> - <span>Similar</span></div>';
			$output .= '<div class="seo-description"></div>';
			$output .= '</div>';
			
			return $output;
		}
	}
?>