<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$output = '';
	
	$id = get_page_id();
	
	if (is_category() || is_tax()) {
						
		$alternative_title = get_term_meta($id, 'additional_title', true);
	}
	else if (is_singular()) {
		
		$alternative_title = get_post_meta($id, 'additional_title', true);
	}
	else {
		
		$alternative_title = is_front_page() ? get_theme_option('seo_options', 'additional_title') : '';
	}

	$title = get_page_title();
	$tagline = get_bloginfo('description');
	$company_name = get_bloginfo('name');

	$separator = get_theme_option('seo_options', 'page_title_separator');
	$format = get_theme_option('seo_options', 'page_title_format');

	switch ($separator) {
		case 1:
			$separator = ' - ';
			break;
		case 2:
			$separator = ' | ';
			break;
		case 3:
			$separator = ', ';
			break;
		case 4:
			$separator = ' > ';
			break;
		case 5:
			$separator = ' ';
			break;
		default:
			$separator = ' - ';
			break;
	}

	$title = empty($title) ? $title : $separator.''.$title;
	$alternative_title = empty($alternative_title) ? $alternative_title : $separator.''.$alternative_title;
	$company_name = empty($company_name) ? $company_name : $separator.''.$company_name;
	$tagline = empty($tagline) ? $tagline : $separator.''.$tagline;

	switch ($format) {
		case 1:
			$output = $title."".$company_name;
			break;
		case 2:
			$output = $title."".$company_name."".$alternative_title;
			break;
		case 3:
			$output = $title."".$alternative_title;
			break;
		case 4:
			$output = $title."".$alternative_title."".$company_name;
			break;
		case 5:
			$output = $company_name."".$title;
			break;
		case 6:
			$output = $company_name."".$title."".$alternative_title;
			break;
		case 7:
			$output = $company_name."".$alternative_title;
			break;
		case 8:
			$output = $company_name."".$alternative_title."".$title;
			break;
		case 9:
			$output = $alternative_title."".$title;
			break;
		case 10:
			$output = $alternative_title."".$title."".$company_name;
			break;
		case 11:
			$output = $alternative_title."".$company_name;
			break;
		case 12:
			$output = $alternative_title."".$company_name."".$title;
			break;
		case 13:
			$output = $company_name." ".$tagline;
			break;
		case 14:
			$output = $company_name." ".$tagline."".$title;
			break;
		case 15:
			$output = $company_name." ".$tagline."".$alternative_title;
			break;
		case 16:
			$output = $company_name;
			break;
		case 17:
			$output = $title;
			break;
		case 18:
			$output = $alternative_title;
			break;
		default:
			$output = $title."".$company_name;
			break;
	}

	$output = substr($output, 0, strlen($separator)) == $separator ? substr_replace($output, '', 0, strlen($separator)) : $output;
	
	echo str_replace('"', "'", trim($output));
?>