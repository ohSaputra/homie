<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace MetaBoxOptions;
	use ThemeOptions as ThemeOptions;

	// Builds a new meta box

	class Build {

		private	$id;
		private	$slug;
		private	$options;
		private	$data;

		public function __construct($id, $slug, $options) {

			$this->id 		= $id;
			$this->slug 	= $slug;
			$this->options 	= $options;
		}

		/**
		 * Builds the custom meta box
		 *
		 * @return string $html
		 */

		public function build_meta_box() {

			$i = 0;
			$k = 0;
			$tabindex = 0;
			$options = array();
			$hidden = array();

			$meta = get_post_custom($this->id);
			$this->data = get_option($this->slug.'_fields');
			
			$output = '';
			$output .= "\n";
			$output .= '<!-- menu starts -->'."\n";
			$output .= "\t".'<ul class="menu tab-menu" data-toggle="tabs" role="tablist">'."\n";

			foreach ($this->data as $label => $fields) {
				
				$i++;
				$class = ($i == 1) ? ' active' : '';
				$output .= "\t\t".'<li class="menu-item'.$class.'"><a class="menu-link" aria-controls="tab-'.$i.'" role="tab" data-toggle="tab" title="'.htmlspecialchars($label).'">'.$label.'</a></li>'."\n";
			}

			$output .= "\t".'</ul>'."\n";
			$output .= '<!-- menu ends -->'."\n\n";

			$output .= '<!-- tabs starts -->'."\n";
			$output .= "\t".'<div class="tabs tab-panel">'."\n";

			foreach ($this->data as $label => $fields) {
				
				$k++;
				$class = ($k == 1) ? ' active' : '';

				$output .= "\t\t".'<!-- tab starts -->'."\n";
				$output .= "\t\t\t".'<div class="tab'.$class.'" id="tab-'.$k.'" role="tabpanel">'."\n";

				$output .= "\t".'<table class="form-table theme-form-table">'."\n";
				$output .= "\t".'<tbody>'."\n";

				foreach ($fields as $id => $field) {

					if ($field['type'] != 'hidden' && $field['type'] != 'divider') {

						$tabindex += 1;

						$value = Save::get_meta_value($field, $meta, $this->id);
						
						$description = (isset($field['description']) && !empty($field['description'])) ? '<span class="description" id="'.ThemeOptions\Field::get_label_name($field['label']).'-info">'.$field['description'].'</span>' : '';
						$toggle = (isset($field['description']) && !empty($field['description'])) ? '<a class="toggle" data-toggle="form-description" data-target="'.ThemeOptions\Field::get_label_name($field['label']).'-info" title="'.__('Show info.', 'admin translation').'">'.__('[+] Info', 'admin translation').'</a>' : '';

						$output .= "\t".'<tr valign="top">'."\n";
						$output .= "\t".'<th class="scope-one" scope="row"><label'.ThemeOptions\Field::get_label_error($field['label']).' for="'.ThemeOptions\Field::get_label_name($field['label']).'">'.$field['name'].' <cite></cite></label></th>'."\n";
						$output .= "\t".'<td class="scope-two">'.ThemeOptions\Field::get_field($this->slug, $field, $value, $options = array('index' => $tabindex)).'<div class="field-info">'.$description.'</div></td>'."\n";
						$output .= "\t".'<td class="scope-three">'.$toggle.'</td>'."\n";
						$output .= "\t".'<td>&nbsp;</td>'."\n";
						$output .= "\t".'</tr>'."\n";
					}
					else {

						if ($field['type'] === 'divider') {

							$output .= "\t".'<tr valign="top">'."\n";
							$output .= "\t".'<th class="scope-divider" colspan="4">'.$field['name'].'</th>'."\n";
							$output .= "\t".'</tr>'."\n";

						}
						else {

							array_push($hidden, $field);
						}
					}
				}

				$output .= "\t".'</tbody>'."\n";
				$output .= "\t".'</table>'."\n\n";

				$output .= "\t\t\t".'</div>'."\n";
				$output .= "\t\t".'<!-- tab ends -->'."\n";
			}
			
			$output .= "\t".'</div>'."\n";
			$output .= '<!-- tabs ends -->'."\n\n";

			if (! empty($hidden)) {

				foreach ($hidden as $id => $field) {

					$value = Save::get_meta_value($field, $meta, $this->id);
					$output .= ThemeOptions\Field::get_field($this->slug, $field, $value, $options = array('index' => '-1'));
				}
			}

			$output .= wp_nonce_field(dirname(__FILE__), $this->slug.'_noncename');

			$output .= ThemeOptions\Field::get_form_feedback();
			
			ThemeOptions\Validation::reset_error();

			echo $output;
		}
	}

?>