<?php 
// Theme Name: Compare Master
// Version: 1.0
// Modified: March 24, 2016


?>
    
    <h1><?php echo __('Protected page', 'theme translation'); ?></h1>
    <p class="lead"><?php echo __('This page is password protected, so in order to view this page, please fill in the provided password below.', 'theme translation'); ?></p>

    <!-- form starts -->
        <form method="post" class="password-form" action="<?php echo home_url(); ?>/wp-login.php?action=postpass">
            <fieldset>

                <div class="form-group">
                    <label for="pwbox-<?php echo $id ?>"><?php echo __('Password', 'theme translation'); ?></label>
                    <input type="password" class="text form-control" name="post_password" id="pwbox-<?php echo $id ?>" tabindex="1" value="" />
                </div>

                <div class="form-action align-right">
                    <button type="submit" class="btn btn-default" name="submit" tabindex="2" data-label="<?php echo __('Sign in', 'theme translation'); ?>"><?php echo __('Sign in', 'theme translation'); ?></button>
                </div>
                
            </fieldset>
        </form>
    <!-- form ends -->
