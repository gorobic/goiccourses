<?php

// disable access to admin area
add_action( 'init', 'blockusers_init' );
function blockusers_init() {
    if ( is_admin() &&  current_user_can( 'subscriber' ) &&
    ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url() );
        exit;
    }
}

// disable admin bar
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    if (current_user_can('subscriber') && !is_admin()) {
        show_admin_bar(false);
    }
}

/**
 * WordPress function for redirecting users on login based on user role
 */
function my_login_redirect( $redirect_to, $request, $user ){
    if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
        if( $user->has_cap( 'administrator' ) ) {
            $redirect_to = admin_url();
        }else{
            if($redirect_to === admin_url()){
                if($account_page = get_theme_mod( 'goicc_account_page' )) {
                    $redirect_to = get_the_permalink($account_page);
                }else{
                    $redirect_to = home_url();
                }
            }
            //$_SERVER["HTTP_REFERER"]
        }
    }
    return $redirect_to;
}
add_filter('login_redirect', 'my_login_redirect', 10, 3 );

// show user new fields in admin area
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );
function extra_user_profile_fields( $user ) { 
    if ( !is_admin()) { 
        return false; 
    }
    ?>
<h3><?php _e("Extra profile information", "blank"); ?></h3>
<table class="form-table">
    <tr>
        <th><label for="is_company"><?php _e("Persoană juridică", 'goicc'); ?></label></th>
        <td>
            <input type="checkbox" name="is_company" id="is_company" value="1"
                <?php if(get_the_author_meta( 'is_company', $user->ID )){echo 'checked';}?> />
            <label for="is_company"><?php _e("Yes", 'goicc'); ?></label><br />
            <span class="description"><?php _e("Check if you are a company."); ?></span>
        </td>
    </tr>
    <?php 
    $user_extra_fields = goicc_get_user_extra_fields();
    foreach($user_extra_fields as $fields_type_key => $fields_type){
        foreach($fields_type as $person_type_key => $person_type){
            foreach($person_type as $field_id => $val){
                ?>
                <tr>
                    <th><label for="<?php echo $field_id; ?>"><?php echo $val['title']; ?></label></th>
                    <td>
                        <input type="text" name="<?php echo $field_id; ?>" id="<?php echo $field_id; ?>"
                            value="<?php echo esc_attr( get_the_author_meta( $field_id, $user->ID ) ); ?>" class="regular-text" />
                        <span class="description"><?php echo $val['desc']; ?></span>
                    </td>
                </tr>
                <?php
            }
        }
    }
    ?>
    
</table>
<?php }

// Edit user new fields (just foar admin area)
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id )  || !is_admin()) { 
        return false; 
    }
    update_user_meta( $user_id, 'is_company', $_POST['is_company'] );
    $user_extra_fields = goicc_get_user_extra_fields();
    foreach($user_extra_fields as $field_types){
        foreach($field_types as $person_types){
            foreach($person_types as $field => $val){
                update_user_meta( $user_id, $field, $_POST[$field] );
            }
        }
    }
}

// disable user email notification
add_filter( 'send_password_change_email', '__return_false' );

function validate_and_save_user_fields($data, $user_id, $user_password = false){
    $user_extra_fields = goicc_get_user_extra_fields();
    $error = array();
    $success = false;

    // Update user password.
    if ( !empty( $data['current_password'] ) && $user_password ){
        $check_password = wp_check_password( $data['current_password'], $user_password, $user_id );
        if($check_password){
            if ( !empty($data['pass1'] ) && !empty( $data['pass2'] ) ) {
                if ( $data['pass1'] === $data['pass2'] )
                    wp_update_user( array( 'ID' => $user_id, 'user_pass' => esc_attr( $data['pass1'] ) ) );
                else
                    $error[] = __('The passwords you entered do not match. Your password was not updated.', 'profile');
            }else{
                $error[] = __('The passwords you entered do not match. Your password was not updated.', 'profile'); 
            }
        }else{
            $error[] = __('Current Password doesn\'t match the existing password.', 'profile'); 
        }
    }elseif( !empty($data['pass1'] ) || !empty( $data['pass2'] ) ){
        $error[] = __('You must confirm the Current Password.', 'profile'); 
    }

    // Update user email.
    if ( !empty( $data['email'] ) ){
        if (!is_email(esc_attr( $data['email'] )))
            $error[] = __('The Email you entered is not valid. Please try again.', 'profile');
        elseif(email_exists(esc_attr( $data['email'] )) && (email_exists(esc_attr( $data['email'] )) !== $user_id ) )
            $error[] = __('This Email is already used by another user. Try a different one.', 'profile');
        else{
            wp_update_user( array ('ID' => $user_id, 'user_email' => esc_attr( $data['email'] )));
        }
    }

    // Update user information.
    if ( !empty( $data['url'] ) )
        wp_update_user( array( 'ID' => $user_id, 'user_url' => esc_url( $data['url'] ) ) );
    
    $is_company = ($data['is_company']) ? 1 : 0;
    update_user_meta( $user_id, 'is_company', $is_company );

    if ( !empty( $data['first_name'] ) )
        update_user_meta( $user_id, 'first_name', esc_attr( $data['first_name'] ) );
    if ( !empty( $data['last_name'] ) )
        update_user_meta($user_id, 'last_name', esc_attr( $data['last_name'] ) );
    if ( !empty( $data['description'] ) )
        update_user_meta( $user_id, 'description', esc_attr( $data['description'] ) );

    // update user extra fields.abs
    foreach($user_extra_fields as $fields_type_key => $fields_type){
        foreach($fields_type as $person_type_key => $person_type){
            foreach($person_type as $field => $val){
                if ( !empty( $data[$field] ) ){
                    update_user_meta( $user_id, $field, esc_attr( $data[$field] ) );
                }elseif( isset( $data[$field] ) &&  empty( $data[$field] ) && $val['required'] ){
                    if( $person_type_key === 'company' && !$data['is_company'] ){
                        continue;
                    }
                    $error[] = '"'. $val['title'] .'" ' . __('must not be empty.','goicc');
                }
            }
        }
    }
    
    // Redirect so the page will show updated info.
    if ( count($error) === 0 ) {
        //action hook for plugins and extra fields saving
        do_action('edit_user_profile_update', $user_id);
        $success = true;
        //wp_redirect( home_url().$_SERVER['REQUEST_URI'] );
        //exit;
    }

    return array(
        'success' => $success,
        'error' => $error,
    );
}

// User accout page url
function accout_page_url(){
    if($account_page_id = get_theme_mod( 'goicc_account_page' )){
        $account_page = get_the_permalink($account_page_id);
    }else{
        $account_page = home_url();
    }
    return $account_page;
}

function user_account_current_tab(){
    $user_account_tabs = goicc_get_user_account_tabs();
    if(isset($_GET['tab']) && array_key_exists($_GET['tab'], $user_account_tabs)){
        $current_tab = $_GET['tab'];
    }else{
        $current_tab = array_key_first($user_account_tabs);
    }
    return $current_tab;
}

function check_active_subscription_to_course($user_id, $course_id){

    if(!$user_id)
    return ['active' => false];

    if(!is_user_logged_in()) 
    return ['active' => false];
    
    if(user_can( $user_id, 'administrator' )) 
    return ['active' => true];

    if(!$course_id)
    return ['active' => false];

    if(get_post_field( 'post_author', $course_id ) === $user_id)
    return ['active' => true];

    // Get list of products IDs for current course
    $connected_products = get_posts( array(
        'connected_type' => 'posts_to_product',
        'connected_items' => $course_id,
        'nopaging' => true,
        'suppress_filters' => false,
        'fields' => 'ids'
    ) );
    
    // set timezone from wordpress settings
    date_default_timezone_set(get_option('timezone_string'));
    
    // Check ACTIVE subscription
    // status paid
    // date between start and end
    // in list of products connected to course
    // orders connected to user
    $args = array(
        'nopaging' => true,
        'suppress_filters' => false,
        'post_type' => array( 'goicc_order' ),
        'connected_type' => 'user_to_order',
        'connected_items' => $user_id,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'     => 'goicc_order_product_id',
                'value'   => $connected_products,
                'compare' => 'IN',
            ),
            array(
                'key'     => 'goicc_order_status',
                'value'   => 'completed',
                'compare' => 'IN',
            ),
            array(
                'key'     => 'goicc_subscription_start_date',
                'value'   => date('Ymd'),
                //'value'   => //date('Ymd', strtotime('+1 day')),
                'compare' => '<=',
            ),
            array(
                'key'     => 'goicc_subscription_end_date',
                'value'   => date('Ymd'),
                'compare' => '>=',
            ),
        ),
    );

    // Check FUTURE subscription
    $args_future = array(
        'nopaging' => true,
        'suppress_filters' => false,
        'post_type' => array( 'goicc_order' ),
        'connected_type' => 'user_to_order',
        'connected_items' => $user_id,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'     => 'goicc_order_product_id',
                'value'   => $connected_products,
                'compare' => 'IN',
            ),
            array(
                'key'     => 'goicc_order_status',
                'value'   => array('failed', 'refunded', 'cancelled'),
                'compare' => 'NOT IN',
            ),
            array(
                'key'     => 'goicc_subscription_start_date',
                'value'   => date('Ymd'),
                'compare' => '>',
            ),
            array(
                'key'     => 'goicc_subscription_end_date',
                'value'   => date('Ymd'),
                'compare' => '>',
            ),
        ),
    );

    date_default_timezone_set('UTC');


    $return = [];
    $posts = get_posts($args);
    $posts_future = get_posts($args_future);

    if($posts && count($posts) > 0){
        $return['active'] = true;
        //$return['active_end'] = get_field('goicc_subscription_end_date', $posts[0]->ID);
        $return['active_end'] = get_post_meta($posts[0]->ID, 'goicc_subscription_end_date', true);
    }else{
        $return['active'] = false;
    }

    if($posts_future && count($posts_future) > 0){
        $return['future'] = true;
        //$return['future_end'] = get_field('goicc_subscription_end_date', $posts_future[0]->post_ID);
    }else{
        $return['future'] = false;
    }
    
    return $return;
}