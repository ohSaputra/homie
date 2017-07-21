<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016

	
	$chat = __('Live Chat', 'theme translation');
	$account = __('Login', 'theme translation');
	$help = __('Free Consultation', 'theme translation');

	$phone_number = get_theme_option('microdata_options', 'phone_number');
    $phone_number = preg_split("/\s+/", $phone_number);
    $phone_number[0] = '<small>'.$phone_number[0].'</small>';
    $phone_number = join(' ', $phone_number);

?>

    <!-- amenity starts -->
        <div class="amenity clearfix">
            <div class="amenity-contact"><span><?php echo $help; ?></span><strong><?php echo $phone_number; ?></strong></div>
            <div class="amenity-action"><a class="anchor" rel="nofollow"><?php echo $chat; ?><i class="icon i-link-chat i-2x"></i></a></div>
            <div class="amenity-action"><a class="anchor" data-toggle="modal" data-target="#account-modal" rel="nofollow"><?php echo $account; ?><i class="icon i-link-account i-2x"></i></a></div>
        </div>
    <!-- amenity ends -->
