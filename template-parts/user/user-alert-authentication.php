<?php 
global $registration_url, $login_url;
?>
<div id="alert-authentication" class="alert-authentication p-3 p-md-5">
    <div class="alert-authentication-content border border-light shadow bg-white rounded p-4 text-center">
        <div class="mb-3">
            <?php _e('To perform this action, you must be logged in to your user account.', 'goicc' ); ?>
        </div>
        <a href="<?php echo $login_url; ?>" class="btn btn-primary m-2">
            <?php _e('Sign In','goicc'); ?>
        </a>

        <?php _e('or','goicc'); ?>

        <a href="<?php echo $registration_url; ?>" class="btn btn-outline-primary m-2">
            <?php _e('Sign Up','goicc'); ?>
        </a>
    </div>
</div>