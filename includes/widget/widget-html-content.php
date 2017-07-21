<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	

	$content = '';
	
	extract($widget);
	extract($instance);
	
	$header = empty($title) ? '' : $before_title.$title.$after_title;
	
	if (isset($layout) && $layout == 1) {
		
		$content .= '<!-- widget starts -->'."\n";
		$content .= empty($html_code) ? '' : $html_code."\n";
		$content .= '<!-- widget ends -->'."\n";
	}
	else {
		
		$content .= $before_widget;
		$content .= $header;
		$content .= '<div class="widget-html">'."\n";
		$content .= empty($html_code) ? '&nbsp;' : $html_code."\n";
		$content .= '</div>'."\n";
		$content .= $after_widget;
	}
	
	echo $content;
?>
