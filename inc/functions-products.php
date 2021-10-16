<?php

function set_currency($price, $args = array()){
    $args = wp_parse_args(
        $args,
        array(
            'currency' => __('lei','goicc'),
            'space' => true,
            'left' => false
        )
    );
    $return = $price;
    if($args['currency']){
        $currency = '<span class="goicc-price-currency-symbol">' . $args['currency'] . '</span>';
        if($args['space']) $space = ' ';
        if($args['left']){
            $return = $currency . $space . $price;
        }else{
            $return = $price . $space . $currency;
        }
    }
    return $return;
}

function check_order($order_full_id){
	$order_id_data = explode('-', $order_full_id);
	$order_id = $order_id_data[0];
	$unique_id = $order_id_data[1];
	$post_unique_id = get_post_meta($order_id, 'goicc_order_unique_id', true);
	if (!is_string($unique_id) || !is_string($post_unique_id) || $unique_id != $post_unique_id) {
		return false;
	}else{
		return $order_id;
	}
}

function render_price($regular_price = 0, $sale_price = 0){
    $price = $regular_price;
    if($sale_price) $price = $sale_price;

    ob_start();
    ?>
    <div class="goicc-price">
        <?php if($sale_price){ ?>
            <del class="text-muted full-price mr-1">
                <?php echo $regular_price; ?> <span class="goicc-price-currency-symbol small font-weight-light"><?php _e('lei','goicc'); ?></span>
            </del>
        <?php } ?>
        <span class="goicc-price-amount text-primary h1">
            <?php echo $price; ?> <span class="goicc-price-currency-symbol small font-weight-light"><?php _e('lei','goicc'); ?></span>
        </span>
    </div>
    <?php
    return ob_get_clean();
}

// Product type SUBSCRIPTION
function get_subscription_start_end_date($user_id, $product_id, $product_meta, $current_id = false){
    $subscription_months = $product_meta['goicc_subscription_months'][0];

    $connected_course = get_posts( array(
        'connected_type' => 'posts_to_product',
        'connected_items' => $product_id,
        'nopaging' => true,
        'suppress_filters' => false,
        'fields' => 'ids'
    ) )[0];

    $subscription_data = get_subscription_data($user_id, $connected_course, $current_id);
    
    if($subscription_data['active']){
        $start_date = strtotime($subscription_data['active_end'] . ' + 1 day');
    }else{
        // set timezone from wordpress settings
        date_default_timezone_set(get_option('timezone_string'));
            
        $start_date = time();

        date_default_timezone_set('UTC');
    }

    $end_date = strtotime(date('d.m.Y', $start_date) . ' + '. $subscription_months .' months - 1 day');

    return [
        'start_date' => $start_date,
        'end_date' => $end_date
    ];
}

add_action('goicc_billing_history_product_extra_details', 'do_billing_history_product_extra_details_product_type_subscription', 10 , 3);
function do_billing_history_product_extra_details_product_type_subscription($user_id, $order_id, $order_meta){
    if($order_meta['goicc_product_type'][0] !== 'subscription') return;
    $dates = get_subscription_start_end_date($user_id, $order_id, $order_meta);
    echo date('d.m.Y', $dates['start_date']) . ' - ' . date('d.m.Y', $dates['end_date']);
}

add_action('goicc_checkout_product_extra_details', 'do_checkout_product_extra_details_product_type_subscription', 10 , 3);
function do_checkout_product_extra_details_product_type_subscription($user_id, $product_id, $product_meta){
    if($product_meta['goicc_product_type'][0] !== 'subscription') return;
    $dates = get_subscription_start_end_date($user_id, $product_id, $product_meta);
    echo date('d.m.Y', $dates['start_date']) . ' - ' . date('d.m.Y', $dates['end_date']);
}

add_action('goicc_create_order','do_create_order_product_type_subscription', 10, 5);
function do_create_order_product_type_subscription($order_id, $user_id, $order_data, $product_data, $product_meta){
    if($product_meta['goicc_product_type'][0] !== 'subscription') return;

    $dates = get_subscription_start_end_date($user_id, $product_data['ID'], $product_meta);
    
    update_field('goicc_subscription_months', $product_meta['goicc_subscription_months'][0], $order_id);
    update_field('goicc_subscription_start_date', date('Ymd', $dates['start_date']), $order_id);
    update_field('goicc_subscription_end_date', date('Ymd', $dates['end_date']), $order_id);
} 

// add_action('updated_post_meta', 'check_order_status_change_to_completed', 0, 4);
// function check_order_status_change_to_completed($meta_id, $post_id, $meta_key, $meta_value) {
//     if( 'goicc_order_status' === $meta_key && 'completed' == $meta_value) {
//         $product_type = get_post_meta($post_id, 'goicc_product_type', true);
//         if($product_type == 'subscription'){

//             $user_id = get_post_field( 'post_author', $post_id );
//             $product_id = get_post_meta($post_id, 'goicc_order_product_id', true);
//             $product_meta = get_post_meta($product_id);

//             $dates = get_subscription_start_end_date($user_id, $product_id, $product_meta, $post_id);

//             // @todo: update-urile de mai jos nu functinoeaza. cred ca postarea se updateaza dupa ce introduc aceste campuri.
//             update_field('goicc_subscription_start_date', date('Ymd', $dates['start_date']), $post_id);
//             update_field('goicc_subscription_end_date', date('Ymd', $dates['end_date']), $post_id);
//             update_post_meta(632, 'goicc_subscription_months', 55);
            
//             wp_mail( 'gorobic@gmail.com', 'Status completed', json_encode($dates) );
//         }
//     }
// }

function action_save_order( $post_id, $post, $update ) { 
    if( !$update ) return;
    if( 'goicc_order' !== $post->post_type ) return;

    $order_update_and_send_email = get_post_meta($post_id, 'goicc_order_update_and_send_email', true);
    if($order_update_and_send_email){
        $order_status = get_post_meta($post_id, 'goicc_order_status', true);
        if( 'completed' == $order_status ){
            $product_type = get_post_meta($post_id, 'goicc_product_type', true);
            if($product_type == 'subscription'){

                $user_id = get_post_field( 'post_author', $post_id );
                $product_id = get_post_meta($post_id, 'goicc_order_product_id', true);
                $product_meta = get_post_meta($product_id);

                $dates = get_subscription_start_end_date($user_id, $product_id, $product_meta, $post_id);

                update_field('goicc_subscription_start_date', date('Ymd', $dates['start_date']), $post_id);
                update_field('goicc_subscription_end_date', date('Ymd', $dates['end_date']), $post_id);
                update_field('goicc_order_update_and_send_email', 0, $post_id);
                
                ob_start();
                get_template_part('templates/emails/order', 'completed-subscription', array('order_id' => $post_id, 'product_id' => $product_id, 'product_meta' => $product_meta));
                $email_body = ob_get_clean();
                // @todo: dacă site-ul va fi bilingv, de memorat în contul utilizatorului preferința de limbă și de afișat subiectul respectiv limbii
                $subject = 'Ați primit acces la curs';
                $headers = array(
                    'Content-Type: text/html; charset=UTF-8',
                    'Reply-To: ' . get_bloginfo('admin_email')
                );

                wp_mail(
                    get_userdata($_POST['user_id'])->user_email,
                    $subject,
                    $email_body,
                    $headers
                ); 
            }
        }
    }
}; 
add_action( 'save_post', 'action_save_order', 10, 3 ); 

//@todo: daca externalizez subscriptions in plugin, sa refac cronul in felul urmator: https://wp-kama.ru/function/wp_schedule_event

//Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'goicc_do_subscription_update' ) ) {
    wp_schedule_event( strtotime('today 5am'), 'daily', 'goicc_do_subscription_update' );
}

///Hook into that action that'll fire every day
add_action( 'goicc_do_subscription_update', 'goicc_cron_subscription_update' );

//create your function, that runs on cron
function goicc_cron_subscription_update() {
    // @todo: rand de cod temporar. de șters ulterior
    // wp_mail( 'gorobic@gmail.com', 'Cursuri hook zilnic', 'Continutul hook-ului' );

    $args = array(
        'nopaging' => true,
        'suppress_filters' => false,
        'post_status' => 'publish',
        'post_type' => array( 'goicc_order' ),
        'meta_query' => array(
            'relation' => 'AND',
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
                'value'   => date('Ymd', strtotime('+5 days')),
                'compare' => '=',
            ),
        ),
    );
    $posts = get_posts($args);
    if($posts){
        $payment_method = goicc_get_payment_method();
        foreach($posts as $post){
            $post = (array) $post;
            
            $old_order_meta = get_post_meta($post['ID']);
            $product_id = $old_order_meta['goicc_order_product_id'][0];

            // Do not create order if the product on which it is based no longer exists on the site
            if(get_post_status($product_id) !== 'publish') continue;

            $subscription_start_date = $old_order_meta['goicc_subscription_end_date'][0];
            
            $order_data = [];
            $user_id = $post['post_author'];
            $order_data['user_id'] = $user_id;
            $order_data['first_name'] = get_the_author_meta( 'first_name', $user_id );
            $order_data['last_name'] = get_the_author_meta( 'last_name', $user_id );
            $order_data['user_email'] = get_the_author_meta( 'user_email', $user_id );
            $order_data['is_company'] = get_the_author_meta( 'is_company', $user_id );
            $order_data['product_id'] = $product_id;

            
            $old_order_payment_method = $old_order_meta['goicc_payment_method'][0];
            if($old_order_payment_method && in_array($old_order_payment_method, array_keys($payment_method))){
                $order_data['payment_method'] = $old_order_payment_method;
            }else{
                $order_data['payment_method'] = array_key_first($payment_method);
            }

            $user_extra_fields = goicc_get_user_extra_fields();
            foreach($user_extra_fields['billing'] as $person_type_key => $person_type){
                foreach($person_type as $field => $val){
                    $order_data[$field] = get_the_author_meta( $field, $user_id );
                }
            }

            $new_order = create_order($order_data, $user_id);

            if($new_order){
                // var_dump($order_data);
                // var_dump($new_order);

                $account_page = accout_page_url();
                $new_order_url = $account_page . '?tab=billing-history&order_id=' . $new_order['order_id'] . '-' . $new_order['order_unique_id'];
                $product_title = get_the_title($order_data['product_id']);
                ob_start();
                get_template_part('templates/emails/customer', 'subscription-update', array('new_order_url' => $new_order_url, 'order_data' => $order_data, 'product_title' => $product_title));
                $email_body = ob_get_clean();
                // @todo: dacă site-ul va fi bilingv, de memorat în contul utilizatorului preferința de limbă și de afișat subiectul respectiv limbii
                $subject = 'A fost emisă o nouă factură proformă';
                $headers = array(
                    'Content-Type: text/html; charset=UTF-8',
                    'Reply-To: ' . get_bloginfo('admin_email')
                );

                wp_mail(
                    $order_data['user_email'],
                    $subject,
                    $email_body,
                    $headers
                );

            }else{
                // @todo: de trimis email sau creat log cu eroarea la creare postare
            }



        }
    }
}