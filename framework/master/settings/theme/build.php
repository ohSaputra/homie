<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace ThemeOptions;

	// Builds a new theme options page

	class Build {

		private	$slug;
		private	$options;
		private	$data;
		private	$error;

		public function __construct($slug, $options) {

			$this->slug 	= $slug;
			$this->options 	= $options;
		}

		/**
		 * Builds the page with custom theme options
		 *
		 * @return string $html
		 */
		
		public function build_menu_page() {

			$tabindex = 0;
			$temp = array();
			$hidden = array();
			$this->data = get_option($this->slug.'_fields');
			
			$output = '';
			$output .= '<!-- wrap starts -->'."\n";
			$output .= "\t".'<div class="wrap">'."\n";

			$output .= '<h1>'.$this->options['title'].'</h1>'."\n";

			$output .= "\t".'<form method="post" action="'.$_SERVER['REQUEST_URI'].'" enctype="multipart/form-data">'."\n\n";

			foreach ($this->data as $section => $fields) {

				$output .= "\t".'<h2 class="title" id="'.sanitize_title($section).'">'.$section.'</h2>'."\n\n";

				$output .= "\t".'<table class="form-table theme-form-table">'."\n";
				$output .= "\t".'<tbody>'."\n";

				foreach ($fields as $id => $field) {

					if ($field['type'] != 'hidden') {

						$tabindex += 1;
						$temp += array($field['label'] => isset($field['value']) ? $field['value'] : '');
						$value = isset($_POST['updating']) ? Save::save_page($this->slug, $field) : Save::set_default_value($this->slug, $temp, $field);

						$description = (isset($field['description']) && !empty($field['description'])) ? '<span class="description" id="'.Field::get_label_name($field['label']).'-info">'.$field['description'].'</span>' : '';
						$toggle = (isset($field['description']) && !empty($field['description'])) ? '<a class="toggle" data-toggle="form-description" data-target="'.Field::get_label_name($field['label']).'-info" title="'.__('Show info.', 'admin translation').'">'.__('[+] Info', 'admin translation').'</a>' : '';

						$output .= "\t".'<tr valign="top">'."\n";
						$output .= "\t".'<th class="scope-one" scope="row"><label'.Field::get_label_error($field['label']).' for="'.Field::get_label_name($field['label']).'">'.$field['name'].' <cite></cite></label></th>'."\n";
						$output .= "\t".'<td class="scope-two">'.Field::get_field($this->slug, $field, $value).'<div class="field-info">'.$description.'</div></td>'."\n";
						$output .= "\t".'<td class="scope-three">'.$toggle.'</td>'."\n";
						$output .= "\t".'<td>&nbsp;</td>'."\n";
						$output .= "\t".'</tr>'."\n";
					}
					else {

						array_push($hidden, $field);
					}
					
				}

				$output .= "\t".'</tbody>'."\n";
				$output .= "\t".'</table>'."\n\n";
				$output .= "\t".'<hr />'."\n\n";
			}

			$output .= isset($_REQUEST['page']) ? "\t".wp_nonce_field($_REQUEST['page'])."\n" : '';

			foreach ($hidden as $id => $field) {

				$temp += array($field['label'] => isset($field['value']) ? $field['value'] : '');
				$value = isset($_POST['updating']) ? Save::save_page($this->slug, $field) : Save::set_default_value($this->slug, $temp, $field);
				
				$output .= Field::get_field($this->slug, $field, $value);
			}
			
			$output .= "\t".'<input type="hidden" id="updating" name="updating" value="1" />'."\n";
			$output .= "\t".'<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="'.__('Save Changes', 'admin translation').'"  /></p>'."\n";
			$output .= "\t".'</form>'."\n";

			$output .= "\t".'</div>'."\n";
			$output .= '<!-- wrap ends -->'."\n\n";

			$output .= Field::get_form_feedback();
			
			Validation::reset_error();

			echo $output;
		}
	}
?>