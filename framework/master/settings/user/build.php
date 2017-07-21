<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace UserOptions;
	use ThemeOptions as ThemeOptions;

	// Builds new user options

	class Build {

		private	$user;
		private	$id;
		private	$slug;
		private	$options;
		private	$meta;
		private	$data;

		public function __construct($user, $slug, $options) {

			$this->user 	= $user;
			$this->id 		= $user->ID;
			$this->slug 	= $slug;
			$this->options 	= $options;
			$this->meta 	= get_user_meta($this->id);
		}

		/**
		 * Builds the custom user options
		 *
		 * @return string $html
		 */

		public function add_options() {
			
			$this->data = get_option($this->slug.'_fields');
			
			$output = '';

			foreach ($this->data as $label => $fields) {

				$output .= "\t".'<hr />'."\n\n";
				$output .= "\t".'<h2>'.$label.'</h2>'."\n\n";

				$output .= "\t".'<table class="form-table theme-form-table">'."\n";
				$output .= "\t\t".'<tbody>'."\n";

				foreach ($fields as $id => $field) {

					$value = array_key_exists($field['label'], $this->meta) == false ? isset($field['value']) ? $field['value'] : '' : get_the_author_meta($field['label'], $this->id);

					$description = (isset($field['description']) && !empty($field['description'])) ? '<span class="description" id="'.ThemeOptions\Field::get_label_name($field['label']).'-info">'.$field['description'].'</span>' : '';
					$toggle = (isset($field['description']) && !empty($field['description'])) ? '<a class="toggle" data-toggle="form-description" data-target="'.ThemeOptions\Field::get_label_name($field['label']).'-info" title="'.__('Show info.', 'admin translation').'">'.__('[+] Info', 'admin translation').'</a>' : '';

					$output .= "\t".'<tr valign="top">'."\n";
					$output .= "\t".'<th class="scope-one" scope="row"><label'.ThemeOptions\Field::get_label_error($field['label']).' for="'.ThemeOptions\Field::get_label_name($field['label']).'">'.$field['name'].' <cite></cite></label></th>'."\n";
					$output .= "\t".'<td class="scope-two">'.ThemeOptions\Field::get_field($this->slug, $field, $value).'<div class="field-info">'.$description.'</div></td>'."\n";
					$output .= "\t".'<td class="scope-three">'.$toggle.'</td>'."\n";
					$output .= "\t".'<td>&nbsp;</td>'."\n";
					$output .= "\t".'</tr>'."\n";
				}

				$output .= "\t\t".'</tbody>'."\n";
				$output .= "\t".'</table>'."\n\n";
			}

			$output .= ThemeOptions\Field::get_form_feedback();
			
			ThemeOptions\Validation::reset_error();

			echo $output;
		}
	}

?>