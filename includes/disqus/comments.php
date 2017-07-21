<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016
	
	
	// Adding required script to the footer
	
	function add_disqus_scripting() {
		
		echo "<script> var disqus_config = function () { this.page.url = 'http://localhost/'; this.page.identifier = 'cekaja'; }; (function() { var d = document, s = d.createElement('script'); s.src = '//EXAMPLE.disqus.com/embed.js'; s.setAttribute('data-timestamp', +new Date()); (d.head || d.body).appendChild(s); })(); </script>"."\n";
	}

	//add_action( 'wp_footer', 'add_disqus_scripting' );
?>

<!-- disqus starts -->
    <aside class="disqus">
        <div id="disqus_config"></div>
    </aside>
<!-- disqus ends -->
