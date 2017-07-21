<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace TaxonomyOptions;
	use ThemeOptions as ThemeOptions;

	// Builds new taxonomy options

	class Build {

		private	$term;
		private	$slug;
		private	$options;
		private	$data;

		public function __construct($term, $slug, $options) {

			$this->term 	= $term;
			$this->slug 	= $slug;
			$this->options 	= $options;
		}

		/**
		 * Builds the custom taxonomy options
		 *
		 * @return string $html
		 */

		public function add_taxonomy() {
			
			$this->data = get_option($this->slug.'_fields');
			
			$output = '';

			foreach ($this->data as $label => $fields) {

				$output .= "\t".'<hr />'."\n\n";
				$output .= "\t".'<h2>'.$label.'</h2>'."\n\n";

				foreach ($fields as $id => $field) {

					$value = (isset($field['value'])) ? $field['value'] : '';

					$description = (isset($field['description']) && !empty($field['description'])) ? '<span class="description" id="'.ThemeOptions\Field::get_label_name($field['label']).'-info">'.$field['description'].'</span>' : '';
					$toggle = (isset($field['description']) && !empty($field['description'])) ? '<a class="toggle" data-toggle="form-description" data-target="'.ThemeOptions\Field::get_label_name($field['label']).'-info" title="'.__('Show info.', 'admin translation').'">'.__('[+] Info', 'admin translation').'</a>' : '';

					$output .= "\t".'<div class="form-field form-table">'."\n";
					$output .= "\t".'<div class="field-label"><label'.ThemeOptions\Field::get_label_error($field['label']).' for="'.ThemeOptions\Field::get_label_name($field['label']).'">'.$field['name'].' <cite></cite></label>'.$toggle.'</div>'."\n";
					$output .= "\t".'<div class="field-input">'.ThemeOptions\Field::get_field($this->slug, $field, $value).'</div>'."\n";
					$output .= "\t".'<div class="field-info">'.$description.'</div>'."\n";
					$output .= "\t".'</div>'."\n";
				}
			}

			$output .= "\t".'<hr />'."\n\n";

			$output .= ThemeOptions\Field::get_form_feedback();
			
			ThemeOptions\Validation::reset_error();

			echo $output;
		}

		/**
		 * Builds the custom taxonomy options
		 *
		 * @return string $html
		 */

		public function edit_taxonomy() {

			$this->data = get_option($this->slug.'_fields');
			$id = $this->term->term_id;

			$output = '';

			foreach ($this->data as $label => $fields) {

				$output .= "\t\t".'<tr class="form-field-header">'."\n";
				$output .= "\t\t\t".'<td colspan="2">'."\n";
				$output .= "\t\t\t\t".'<hr />'."\n";
				$output .= "\t\t\t\t".'<h2>'.$label.'</h2>'."\n";
				$output .= "\t\t\t".'</td>'."\n";
				$output .= "\t\t".'</tr>'."\n";

				foreach ($fields as $object => $field) {

					$value = get_term_meta($id, $field['label'], true);

					$description = (isset($field['description']) && !empty($field['description'])) ? '<span class="description" id="'.ThemeOptions\Field::get_label_name($field['label']).'-info">'.$field['description'].'</span>' : '';
					$toggle = (isset($field['description']) && !empty($field['description'])) ? '<a class="toggle" data-toggle="form-description" data-target="'.ThemeOptions\Field::get_label_name($field['label']).'-info" title="'.__('Show info.', 'admin translation').'">'.__('[+] Info', 'admin translation').'</a>' : '';

					$output .= "\t\t".'<tr class="form-field">'."\n";
					$output .= "\t\t\t".'<th class="scope-one" scope="row"><label'.ThemeOptions\Field::get_label_error($field['label']).' for="'.ThemeOptions\Field::get_label_name($field['label']).'">'.$field['name'].' <cite></cite></label></th>'."\n";
					$output .= "\t\t\t".'<td class="scope-two"><div class="form-content">'.ThemeOptions\Field::get_field($this->slug, $field, $value).'<div class="field-info">'.$description.'</div>'.$toggle.'</div></td>'."\n";
					$output .= "\t\t".'</tr>'."\n";
				}
			}
						
			$output .= ThemeOptions\Field::get_form_feedback();
			
			ThemeOptions\Validation::reset_error();

			echo $output;
		}
	}

?>