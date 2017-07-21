<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	if (is_active_sidebar('search-widgets')) {

		dynamic_sidebar('search-widgets');
	}
	else {
		
		echo '&nbsp;';
	}
?>
