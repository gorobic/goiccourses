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

// @todo: de externalizat în plugin pentru fiecare product type funcțiile. sau în fișier separat.

// Product type SUBSCRIPTION
function get_subscription_start_end_date($user_id, $product_id, $product_meta){
    $subscription_months = $product_meta['goicc_subscription_months'][0];

    $connected_course = get_posts( array(
        'connected_type' => 'posts_to_product',
        'connected_items' => $product_id,
        'nopaging' => true,
        'suppress_filters' => false,
        'fields' => 'ids'
    ) )[0];

    $active_subscription = check_active_subscription_to_course($user_id, $connected_course);
    
    if($active_subscription['active']){
        $start_date = strtotime($active_subscription['active_end'] . ' + 1 day');
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