<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

    
    $open_hours = get_theme_option('microdata_options', 'open_hours');

    $phone_number = get_theme_option('microdata_options', 'phone_number');
    $phone_number = preg_split("/\s+/", $phone_number);
    $phone_number[0] = '<small>'.$phone_number[0].'</small>';
    $phone_number = join(' ', $phone_number);

    $telephone = get_theme_option('microdata_options', 'itemprop_phone_number');
    $contact_type = get_theme_option('microdata_options', 'itemprop_contact_type');
    $opens = get_theme_option('microdata_options', 'itemprop_opens');
    $closes = get_theme_option('microdata_options', 'itemprop_closes');
    $day_of_week = get_theme_option('microdata_options', 'itemprop_day_of_week');

    $geo_coordinates = get_theme_option('microdata_options', 'itemprop_geo_coordinates');
?>
    
    <!-- contact starts -->
        <div class="contact">
            <div class="phone" itemprop="contactPoint" itemscope itemtype="http://schema.org/ContactPoint">
                <strong><i class="icon i-display-phone-right i-3x"></i><?php echo $phone_number; ?></strong>
                <meta itemprop="contactType" content="<?php echo $contact_type; ?>" />
                <meta itemprop="telephone" content="<?php echo $telephone; ?>" />
            </div>
            <div class="time" itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
                <span><?php echo $open_hours; ?></span>
                <meta itemprop="dayOfWeek" content="<?php echo $day_of_week; ?>">
                <meta itemprop="opens" content="T<?php echo $opens; ?>">
                <meta itemprop="closes" content="T<?php echo $closes; ?>">
            </div>
            <div class="geolocation" itemprop="geo" itemscope="" itemtype="http://schema.org/GeoCoordinates">
                <meta itemprop="latitude" content="<?php echo isset($geo_coordinates['latitude']) ? $geo_coordinates['latitude'] : ''; ?>" />
                <meta itemprop="longitude" content="<?php echo isset($geo_coordinates['longitude']) ? $geo_coordinates['longitude'] : ''; ?>" />
            </div>
        </div>
    <!-- contact ends -->
