<form method="post" id="adduser" action="<?php echo home_url().$_SERVER['REQUEST_URI']; ?>">
    <h4>
        <?php _e('Billing info','goicc'); ?>
    </h4>
    <p class="mt-4">
        <input type="checkbox" name="is_company" id="is_company" value="1"
            <?php if(is_user_logged_in() && get_the_author_meta( 'is_company', $user_id )){echo 'checked';}?> />
        <label
            for="is_company"><?php _e("Persoană juridică", 'goicc'); get_the_author_meta( 'is_company', $user_id ); ?></label></label>
    </p>

    <div class="row">
        <div class="col-lg-6">
            <p class="form-username">
                <label for="first_name"><?php _e('First Name', 'goicc'); ?> *</label>
                <input class="text-input form-control" name="first_name" type="text" id="first_name"
                    value="<?php if(is_user_logged_in()){ the_author_meta( 'first_name', $user_id ); } ?>" required />
            </p>
        </div>
        <div class="col-lg-6">
            <p class="form-username">
                <label for="last_name"><?php _e('Last Name', 'goicc'); ?> *</label>
                <input class="text-input form-control" name="last_name" type="text" id="last_name"
                    value="<?php if(is_user_logged_in()){ the_author_meta( 'last_name', $user_id ); } ?>" required />
            </p>
        </div>
    </div>

    <?php
    $user_extra_fields = goicc_get_user_extra_fields();
    foreach($user_extra_fields['billing'] as $person_type_key => $person_type){
        if($person_type_key === 'company'){
            echo '<div class="only-company">';
        }

        foreach($person_type as $field => $val){
            ?>
            <p class="form-field">
                <label for="<?php echo $field; ?>"><?php echo $val['title']; ?> <?php if($val['required']){ echo '*'; } ?></label>
                <input class="text-input form-control" name="<?php echo $field; ?>" type="text" id="<?php echo $field; ?>"
                    value="<?php if(is_user_logged_in()){ the_author_meta( $field, $user_id ); } ?>"
                    <?php if($val['required']){ echo 'required'; } ?> />
                <?php if($val['desc']){ ?>
                    <small class="form-text text-muted"><?php echo $val['desc']; ?></small>
                <?php } ?>
            </p>
            <?php
        }

        if($person_type_key === 'company'){
            echo '</div>';
        }
    } ?>

    


    <p class="form-submit">
        <?php //echo $referer; ?>
        <input name="updateuser" type="submit" id="updateuser" class="submit button btn btn-primary"
            value="<?php _e('Update', 'goicc'); ?>" />
        <?php wp_nonce_field( 'update-user' ) ?>
        <input name="action" type="hidden" id="action" value="update-user" />
    </p><!-- .form-submit -->
</form><!-- #adduser -->