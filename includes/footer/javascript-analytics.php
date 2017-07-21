<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$output = '';
	
	$code = get_theme_option('seo_options', 'google_analytics_code');
	
	if (!empty($code)) {
			
		$output .= "\n".'<script>'."\n";
		$output .= "\t"."(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga');"."\n";
		$output .= "\t"."ga('create', '".$code."', 'auto');"."\n";
		$output .= "\t"."ga('send', 'pageview');"."\n";
		$output .= "</script>"."\n";
	}

	echo $output;
?>