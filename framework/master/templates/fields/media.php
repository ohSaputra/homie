<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;
	
	// Media library field options available
	//
	// name 			= The label name visible for the user
	// label 			= The identification name (should be a unique variable name)
	// validation 		= The validation function for this field or option (could be a custom call function)
	// type				= The type name of this field (media)
	// rendering 		= The rendering type of this field (single or multiple)
	// lazyload 		= The option to disable lazyload on image rendering, default is always enabled (true or false)
	// output			= The image size of final image in width and height, requires an array of ['width'] and ['height']
	// description 		= The description of what this field will do for the user
	//

	class Media_Field {

		/**
		 * Returns an media library field
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
			
			$class = isset($options['class']) ? $options['class'] : 'regular-text';
			$id = isset($options['id']) ? $options['id'] : Field::get_label_name($field['label']);
			$name = isset($options['name']) ? $options['name'] : THEME_NAME.'_'.$field['label'];
			$tabindex = isset($options['index']) ? ' tabindex="'.$options['index'].'"' : '';
			$rendering = isset($field['rendering']) ? $field['rendering'] : '';
			$form = isset($options['form']) ? $options['form'] : '';
			$multiple = $rendering === 'multiple' ? 'multiple' : 'single';
			$gallery = $rendering === 'multiple' ? ' data-gallery="'.$id.'-gallery"' : '';
			$children = count($value);
			$error = 0;

			if (!empty($value) && is_array($value) && min($value) && isset($value[0]['id']) && !empty($value[0]['id'])) {

				$output .= '<div class="image-upload-wrapper"'.$gallery.' data-multiple="'.$multiple.'">'."\n";

				foreach ($value as $key => $image) {

					$media = wp_get_attachment_image_src($image['id'], 'medium');
					$src = empty($media) ? THEME_ADMIN_ASSETS.'/img/media-missing.png' : $media[0];
					$error = empty($media) ? 1 : $error;

					$width = $form === 'widget' ? 400 : 480;
					$height = round($width / (empty($image['ratio']) ? 1.5 : $image['ratio']));

					$output .= '<div class="image-upload" id="'.$id.'-'.$key.'-upload">'."\n";
					
					$output .= '<div class="image-display">'."\n";
					$output .= '<div class="image-preview"><a class="link update-image-button" data-label="'.__('Choose Image', 'admin translation').'" data-title="'.sprintf(__('Change %s', 'theme translation'), $field['name']).'" data-id="'.$id.'-'.$key.'" title="'.__('Change image', 'admin translation').'"><img src="'.$src.'" width="'.$width.'" height="'.$height.'" class="image-media" alt="" /></a></div>'."\n";
					
					$output .= '<div class="image-action edit-image-action">';
					$output .= '<a class="link update-image-button" data-label="'.__('Choose Image', 'admin translation').'" data-title="'.sprintf(__('Change %s', 'theme translation'), $field['name']).'" data-id="'.$id.'-'.$key.'" title="'.__('Change image', 'admin translation').'"><span class="dashicons dashicons-edit"></span></a>';
					$output .= '<a class="link remove-image-button" data-id="'.$id.'-'.$key.'" title="'.__('Remove image', 'admin translation').'"><span class="dashicons dashicons-no"></span></a>';
					$output .= '</div>'."\n";

					if ($rendering === 'multiple') {

						$output .= '<div class="image-action edit-image-action ordering-image-action">';
						$output .= '<a class="link move-image-button move-up-image-button" data-target="'.$id.'-'.$key.'-upload" title="'.__('Move this image up', 'admin translation').'"><span class="dashicons dashicons-arrow-up"></span></a>';
						$output .= '<em>'.($key + 1).'</em>';
						$output .= '<a class="link move-image-button move-down-image-button" data-target="'.$id.'-'.$key.'-upload" title="'.__('Move this image down', 'admin translation').'"><span class="dashicons dashicons-arrow-down"></span></a>';
						$output .= '</div>'."\n";
					}

					$output .= '</div>'."\n";

					$output .= '<input type="hidden" name="'.$name.'['.$key.'][id]" id="'.$id.'-'.$key.'-id" value="'.(empty($media) ? '' : $image['id']).'" />'."\n";
					$output .= '<input type="hidden" class="'.$class.'" name="'.$name.'['.$key.'][path]" id="'.$id.'-'.$key.'-path" size="36" value="'.(empty($media) ? '' : $image['url']).'" />'."\n";
					$output .= '<div class="image-action upload-image-action hidden" id="'.$id.'-'.$key.'-upload"><a class="link upload-image-button" data-label="'.__('Choose Image', 'admin translation').'" data-title="'.sprintf(__('Upload %s', 'theme translation'), $field['name']).'" data-id="'.$id.'-'.$key.'" title="'.__('Upload image', 'admin translation').'"><span class="dashicons dashicons-admin-media"></span>'.__('Upload image', 'admin translation').'</a></div>'."\n";

					$output .= '<input type="hidden" name="'.$name.'['.$key.'][crop][x]" id="'.$id.'-'.$key.'-crop-x" value="" />'."\n";
					$output .= '<input type="hidden" name="'.$name.'['.$key.'][crop][y]" id="'.$id.'-'.$key.'-crop-y" value="" />'."\n";
					$output .= '<input type="hidden" name="'.$name.'['.$key.'][crop][w]" id="'.$id.'-'.$key.'-crop-w" value="" />'."\n";
					$output .= '<input type="hidden" name="'.$name.'['.$key.'][crop][h]" id="'.$id.'-'.$key.'-crop-h" value="" />'."\n";

					$output .= '<input type="hidden" class="image-ordering" name="'.$name.'['.$key.'][ordering]" id="'.$id.'-'.$key.'-ordering" value="" />'."\n";
					
					$output .= '</div>'."\n";
				}

				if ($rendering === 'multiple') {
					
					$key = count($value);

					$output .= '<div class="image-upload" id="'.$id.'-'.$key.'-upload">'."\n";

					$output .= '<div class="image-display hidden">'."\n";
					$output .= '<div class="image-preview"><a class="link update-image-button" data-label="'.__('Choose Image', 'admin translation').'" data-title="'.sprintf(__('Change %s', 'theme translation'), $field['name']).'" data-id="'.$id.'-'.$key.'" title="'.__('Change image', 'admin translation').'"></a></div>'."\n";
					$output .= '<div class="image-action edit-image-action">';
					$output .= '<a class="link update-image-button" data-label="'.__('Choose Image', 'admin translation').'" data-title="'.sprintf(__('Change %s', 'theme translation'), $field['name']).'" data-id="'.$id.'-'.$key.'" title="'.__('Change image', 'admin translation').'"><span class="dashicons dashicons-edit"></span></a>';
					$output .= '<a class="link remove-image-button" data-id="'.$id.'-'.$key.'" title="'.__('Remove image', 'admin translation').'"><span class="dashicons dashicons-no"></span></a>';
					$output .= '</div>'."\n";

					$output .= '<div class="image-action edit-image-action ordering-image-action">';
					$output .= '<a class="link move-image-button move-up-image-button" data-target="'.$id.'-'.$key.'-upload" title="'.__('Move this image up', 'admin translation').'"><span class="dashicons dashicons-arrow-up"></span></a>';
					$output .= '<em>'.($key + 1).'</em>';
					$output .= '<a class="link move-image-button move-down-image-button" data-target="'.$id.'-'.$key.'-upload" title="'.__('Move this image down', 'admin translation').'"><span class="dashicons dashicons-arrow-down"></span></a>';
					$output .= '</div>'."\n";

					$output .= '</div>'."\n";

					$output .= '<input type="hidden" name="'.$name.'['.$key.'][id]" id="'.$id.'-'.$key.'-id" value="" />'."\n";
					$output .= '<input type="text" class="'.$class.'" name="'.$name.'['.$key.'][path]" id="'.$id.'-'.$key.'-path" size="36" value="" />'."\n";
					$output .= '<div class="image-action upload-image-action" id="'.$id.'-'.$key.'-upload"><a class="link upload-image-button" data-label="'.__('Choose Image', 'admin translation').'" data-title="'.sprintf(__('Upload %s', 'theme translation'), $field['name']).'" data-id="'.$id.'-'.$key.'" title="'.__('Upload image', 'admin translation').'"><span class="dashicons dashicons-admin-media"></span>'.__('Upload image', 'admin translation').'</a></div>'."\n";

					$output .= '<input type="hidden" name="'.$name.'['.$key.'][crop][x]" id="'.$id.'-'.$key.'-crop-x" value="" />'."\n";
					$output .= '<input type="hidden" name="'.$name.'['.$key.'][crop][y]" id="'.$id.'-'.$key.'-crop-y" value="" />'."\n";
					$output .= '<input type="hidden" name="'.$name.'['.$key.'][crop][w]" id="'.$id.'-'.$key.'-crop-w" value="" />'."\n";
					$output .= '<input type="hidden" name="'.$name.'['.$key.'][crop][h]" id="'.$id.'-'.$key.'-crop-h" value="" />'."\n";
					
					$output .= '<input type="hidden" class="image-ordering" name="'.$name.'['.$key.'][ordering]" id="'.$id.'-'.$key.'-ordering" value="" />'."\n";

					$output .= '</div>'."\n";
				}

				$output .= '</div>'."\n";
				$output .= $rendering === 'multiple' ? "\n".'<input type="hidden" class="image-gallery" name="'.$name.'[gallery]" id="'.$id.'-gallery" value="" />'."\n" : '';
			}
			else {

				$key = 0;

				$output .= '<div class="image-upload-wrapper"'.$gallery.' data-multiple="'.$multiple.'">'."\n";

				$output .= '<div class="image-upload" id="'.$id.'-'.$key.'-upload">'."\n";

				$output .= '<div class="image-display hidden">'."\n";
				$output .= '<div class="image-preview"><a class="link update-image-button" data-label="'.__('Choose Image', 'admin translation').'" data-title="'.sprintf(__('Change %s', 'theme translation'), $field['name']).'" data-id="'.$id.'-'.$key.'" title="'.__('Change image', 'admin translation').'"></a></div>'."\n";
				$output .= '<div class="image-action edit-image-action">';
				$output .= '<a class="link update-image-button" data-label="'.__('Choose Image', 'admin translation').'" data-title="'.sprintf(__('Change %s', 'theme translation'), $field['name']).'" data-id="'.$id.'-'.$key.'" title="'.__('Change image', 'admin translation').'"><span class="dashicons dashicons-edit"></span></a>';
				$output .= '<a class="link remove-image-button" data-id="'.$id.'-'.$key.'" title="'.__('Remove image', 'admin translation').'"><span class="dashicons dashicons-no"></span></a>';
				$output .= '</div>'."\n";

				if ($rendering === 'multiple') {
					
					$output .= '<div class="image-action edit-image-action ordering-image-action">';
					$output .= '<a class="link move-image-button move-up-image-button" data-target="'.$id.'-'.$key.'-upload" title="'.__('Move this image up', 'admin translation').'"><span class="dashicons dashicons-arrow-up"></span></a>';
					$output .= '<em>'.($key + 1).'</em>';
					$output .= '<a class="link move-image-button move-down-image-button" data-target="'.$id.'-'.$key.'-upload" title="'.__('Move this image down', 'admin translation').'"><span class="dashicons dashicons-arrow-down"></span></a>';
					$output .= '</div>'."\n";
				}
					
				$output .= '</div>'."\n";

				$output .= '<input type="hidden" name="'.$name.'['.$key.'][id]" id="'.$id.'-'.$key.'-id" value="" />'."\n";
				$output .= '<input type="text" class="'.$class.'" name="'.$name.'['.$key.'][path]" id="'.$id.'-'.$key.'-path" size="36" value="" />'."\n";
				$output .= '<div class="image-action upload-image-action" id="'.$id.'-'.$key.'-upload"><a class="link upload-image-button" data-label="'.__('Choose Image', 'admin translation').'" data-title="'.sprintf(__('Upload %s', 'theme translation'), $field['name']).'" data-id="'.$id.'-'.$key.'" title="'.__('Upload image', 'admin translation').'"><span class="dashicons dashicons-admin-media"></span>'.__('Upload image', 'admin translation').'</a></div>'."\n";

				$output .= '<input type="hidden" name="'.$name.'['.$key.'][crop][x]" id="'.$id.'-'.$key.'-crop-x" value="" />'."\n";
				$output .= '<input type="hidden" name="'.$name.'['.$key.'][crop][y]" id="'.$id.'-'.$key.'-crop-y" value="" />'."\n";
				$output .= '<input type="hidden" name="'.$name.'['.$key.'][crop][w]" id="'.$id.'-'.$key.'-crop-w" value="" />'."\n";
				$output .= '<input type="hidden" name="'.$name.'['.$key.'][crop][h]" id="'.$id.'-'.$key.'-crop-h" value="" />'."\n";
				
				$output .= '<input type="hidden" class="image-ordering" name="'.$name.'['.$key.'][ordering]" id="'.$id.'-'.$key.'-ordering" value="" />'."\n";
				
				$output .= '</div>'."\n";

				$output .= '</div>'."\n";
				$output .= $rendering === 'multiple' ? "\n".'<input type="hidden" class="image-gallery" name="'.$name.'[gallery]" id="'.$id.'-gallery" value="" />'."\n" : '';
			}

			echo empty($error) ? '' : '<div class="notice notice-error is-dismissible"><p><strong>'.__('Media missing.', 'admin translation').'</strong> '.__('It looks like an image has been deleted from the media library.', 'admin translation').'</p></div>';

			wp_enqueue_media();
  			wp_enqueue_script('js-admin-media', THEME_ADMIN_ASSETS.'/js/admin-media.min.js', array('jquery'), false, true);
			
			return $output;
		}
	}
?>