<?php 
// Theme Name: Theme Master
// Version: 1.0
// Modified: March 24, 2016

	
	namespace WidgetOptions;
	use ThemeOptions as ThemeOptions;

	// Builds a widget

	class Build extends \WP_Widget {

		private	$slug;
		private	$fields;

		public function __construct($options) {

			$slug 				= str_replace('_', '-', $options['slug']);
			$this->slug 		= $slug;

			$this->fields 		= $options['options'];
			$widget_options 	= array('classname' => $options['class'], 'description' => $options['description']);
			$control_options 	= array('id_base' => strtolower(THEME_NAME.'-'.$slug));

			parent::__construct(strtolower(THEME_NAME.'-'.$slug), $options['title'], $widget_options, $control_options);

			$this->option_name = str_replace('-', '_', $this->option_name);
		}

		/**
		 * Builds the custom widget
		 *
		 * @return string $html
		 */

		public function widget($widget, $instance) {
				
			$template = 'includes/widget/'.$this->widget_options['classname'].'.php';
			$locate = locate_template($template);
			$role = get_user_role();

			if (empty($locate)) {

				if ($role == 'administrator' || $role == 'editor' || $role == 'author') {

					echo "\n".'<!-- alert starts -->'."\n\t".'<div class="alert alert-danger text-center" role="alert">'.sprintf(__("%s Override template is missing, please check the file '%s'.", "admin translation"), '<strong>'.__('Warning!', 'admin translation').'</strong><br>', '<strong>'.$template.'</strong>').'</div>'."\n".'<!-- alert ends -->'."\n\n";
				}
			}
			else {

				include($locate);
			}
		}

		/**
		 * Updates the custom widget
		 *
		 * @return string $html
		 */

		public function update($new_instance, $old_instance) {

			$remove = '';
			$instance = array();
			$temp = array();

			foreach ($this->fields as $key => $field) {

				$label = $field['label'];
				
				if (! isset($new_instance[$label])) { 
					
					$temp = array($label => '');
				} 
				else {

					if ($field['type'] === 'media') {

						$result = ThemeOptions\Validate\media::validate($this->slug, $new_instance, $field, array('form' => 'widget'));

						$temp = array($label => $result['value']);
					}
					else {

						$temp = array($label => $new_instance[$label]);
					}
				}

				$instance = array_merge($instance, $temp);
			}

			return $instance;
		}

		/**
		 * Returns form value
		 *
		 * @param $instance - saved value in database
		 * @param $field 	- array of current field settings
		 *
		 * @return mixed
		 */

		private function value($instance, $field) {

			$value = '';

			if (isset($instance[$field['label']]) && !empty($instance[$field['label']])) { 

				$value = is_array($instance[$field['label']]) ? $instance[$field['label']] : esc_attr($instance[$field['label']]); 
			}
			else { 

				$value = isset($field['value']) ? $field['value'] : ''; 
			}

			return $value;
		}

		/**
		 * Adds a custom form to a widget
		 *
		 * @return string $html
		 */

		public function form($instance) {

			$tabindex = 0;
			$output = '';

			foreach ($this->fields as $key => $field) {

				$tabindex += 1;

				$value = self::value($instance, $field);
				$name = $this->get_field_name($field['label']);
				$id = $this->get_field_id(str_replace('_', '-', $field['label']));

				$options = array('class' => 'widefat', 'name' => $name, 'id' => $id, 'form' => 'widget');

				$output .= '<div class="widget-form">';
				$output .= '<label'.ThemeOptions\Field::get_label_error($field['label']).' for="'.$id.'">'.$field['name'].': <cite></cite></label>';
				$output .= ThemeOptions\Field::get_field($this->id_base, $field, $value, $options)."\n";
				$output .= '</div>';
			}

			echo $output;
		}
	}

?>