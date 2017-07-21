<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$output = '';

	$source = get_theme_option('layout_options', 'logo');
	$description = get_bloginfo('description');

	$url = home_url();
	$logo = isset($source[0]['url']) ? site_url().$source[0]['url'] : '';
	$company = get_bloginfo('name');	

	if (! empty($logo)) {

		$height = isset($source[0]['output']['height']) ? $source[0]['output']['height'] : '48';
		$width = round($height * $source[0]['ratio']);
	
		$output = '<a href="'.$url.'" itemprop="url"><img src="'.$logo.'" width="'.$width.'" height="'.$height.'" itemprop="logo" alt="'.$description.'" /></a>'."\n";
	}
?>
	
	<!-- logo starts -->
        <div class="logo">
        	<?php echo $output; ?>
            <meta itemprop="name" content="<?php echo $company; ?>" />
            <meta itemprop="additionalType" content="http://schema.org/InsuranceAgency" />
        </div>
    <!-- logo ends -->
