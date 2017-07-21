<?php 
/**
 * The template for displaying the sidebar element
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Compare_Master
 * @since Compare Master 1.0
 */

?>
<?php
	
	$type = get_page_type();
	
	switch ($type) {

		case 'page':

			get_template_part('includes/sidebar/sidebar', 'page');

		break;
		case 'post':

			get_template_part('includes/sidebar/sidebar', 'post');

		break;
		case 'search':

			get_template_part('includes/sidebar/sidebar', 'search');

		break;
		default:
		
			get_template_part('includes/sidebar/sidebar', '');
			
		break;
	}
?>
