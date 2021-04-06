<form method="post" id="adduser" action="<?php echo home_url().$_SERVER['REQUEST_URI']; ?>">
    <p class="form-username">
        <label for="username"><?php _e('User name', 'profile'); ?></label>
        <input class="text-input form-control" name="username" type="text" id="username" disabled
            value="<?php the_author_meta( 'user_login', $user_id ); ?>" />
        <small class="form-text text-muted"><?php _e('Usernames cannot be changed.', 'goicc'); ?></small>
    </p>
    <p class="form-email">
        <label for="email"><?php _e('Email *', 'profile'); ?></label>
        <input class="text-input form-control" name="email" type="text" id="email"
            value="<?php the_author_meta( 'user_email', $user_id ); ?>" required />
    </p>
    <hr class="my-4">

    <h4>
        <?php _e('Password change','goicc'); ?>
    </h4>

    <p class="form-password">
        <label for="current_password"><?php _e('Current Password', 'profile'); ?> </label>
        <input class="text-input form-control" name="current_password" type="password" id="current_password" />
        <small class="form-text text-muted"><?php _e('Leave blank to leave unchanged', 'goicc'); ?></small>
    </p><!-- .form-password -->
    <p class="form-password">
        <label for="pass1"><?php _e('New Password', 'profile'); ?> </label>
        <input class="text-input form-control" name="pass1" type="password" id="pass1" />
        <small class="form-text text-muted"><?php _e('Leave blank to leave unchanged', 'goicc'); ?></small>
    </p><!-- .form-password -->
    <p class="form-password">
        <label for="pass2"><?php _e('Repeat New Password', 'profile'); ?> </label>
        <input class="text-input form-control" name="pass2" type="password" id="pass2" />
        <small class="form-text text-muted"><?php _e('Leave blank to leave unchanged', 'goicc'); ?></small>
    </p><!-- .form-password -->

    <?php 
        //action hook for plugin and extra fields
        do_action('edit_user_profile', $current_user); 
    ?>
    <p class="form-submit">
        <?php echo $referer; ?>
        <input name="updateuser" type="submit" id="updateuser" class="submit button btn btn-primary"
            value="<?php _e('Update', 'profile'); ?>" />
        <?php wp_nonce_field( 'update-user' ) ?>
        <input name="action" type="hidden" id="action" value="update-user" />
    </p><!-- .form-submit -->
</form><!-- #adduser -->