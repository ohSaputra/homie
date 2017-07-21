<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

    
    $postal_address = get_theme_option('microdata_options', 'postal_address');
    $street_address = get_theme_option('microdata_options', 'itemprop_street_address');
    $city = get_theme_option('microdata_options', 'itemprop_city');
    $postal_code = get_theme_option('microdata_options', 'itemprop_postal_code');
    $state = get_theme_option('microdata_options', 'itemprop_state');
    $country = get_theme_option('microdata_options', 'itemprop_country');
?>
	
	<!-- address starts -->
        <div class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <address><?php echo $postal_address; ?></address>
            <meta itemprop="streetAddress" content="<?php echo $street_address; ?>" />
            <meta itemprop="addressLocality" content="<?php echo $city; ?>" />
            <meta itemprop="postalCode" content="<?php echo $postal_code; ?>" />
            <meta itemprop="addressRegion" content="<?php echo $state; ?>" />
            <meta itemprop="addressCountry" content="<?php echo $country; ?>" />
        </div>
    <!-- address ends -->
