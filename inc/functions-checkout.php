<?php

add_action( 'wp_ajax_nopriv_send_checkout_form', 'send_checkout_form' );
add_action( 'wp_ajax_send_checkout_form', 'send_checkout_form' );
function send_checkout_form() {
    global $user_id;

    $order = create_order($_POST);

    $update_user_result = validate_and_save_user_fields($_POST, $user_id);

    // dacă $order are un ID sa trimita mai departe, in caz contrar nu s-a creat postarea, 
    // trebuie inregistrat un log cu eroarea si de afisat eroare.
    if($order){ 
        // $checkout_page_id = get_theme_mod( 'goicc_checkout_page' );
        // $checkout_page_permalink = get_the_permalink( $checkout_page_id );
        // global $checkout_page_permalink;

        $redirect_permalink = CHECKOUT_PAGE_PERMALINK . '?status=success&orderId=' . $order['order_id'] . '-' . $order['order_unique_id'];
        $return_data = array(
            'content' => $redirect_permalink,
            'method' => 'GET', // GET or POST 
            'success' => true,
            'message' => __('Form successfully submitted.','goicc')
        );  

        $return = apply_filters( 'goicc_send_checkout_form', $return_data, $_POST['payment_method'], $order, CHECKOUT_PAGE_PERMALINK, $user_id );

        $account_page = accout_page_url();
        ob_start();
        get_template_part('templates/emails/order', 'submit', array('order_id' => $order, 'account_page' => $account_page ));
        $email_body = ob_get_clean();
        // @todo: dacă site-ul va fi bilingv, de memorat în contul utilizatorului preferința de limbă și de afișat subiectul respectiv limbii
        $subject = 'Vă mulțumim pentru achiziționarea serviciilor noastre';
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
    }else{
        $return = array(
            'success' => false,
            'message' => __('An error occurred. Please try again.','goicc')
        );
        // @todo: de trimis email catre administrator site cu eroarea la inscriere
    }

    wp_send_json($return);
    die();
}

function create_order($order_data = [], $user_id_custom = false){
    if(empty($order_data)) return false;

    $product_data = get_post($order_data['product_id'], 'ARRAY_A');
    $product_meta = get_post_meta($order_data['product_id']);

    global $user_id;
    if($user_id_custom){
        $post_author = $user_id_custom;
    }elseif($order_data['user_id']){
        $post_author = $order_data['user_id'];
    }elseif($user_id){
        $post_author = $user_id;
    }else{
        $post_author = false;
    }
    // $post_author = ($user_id) ? $user_id : $order_data['user_id'];

    $post_title = $order_data['first_name'] . ' ' . $order_data['last_name'] . ' || ' . $product_data['post_title'];
	$order_id = wp_insert_post([
		'post_author' => $post_author,
		'post_title' => $post_title,
		'post_status' => 'publish',
		'post_type' => 'goicc_order'
    ]);

    if(!$order_id) return false; // @todo: de setat un log care notează că nu a putut fi creată postarea
    
    $user_info = get_userdata($post_author);

    $order_unique_id = uniqid();
    $user_email = ($order_data['user_email']) ? $order_data['user_email'] : $user_info->user_email;
    update_field('goicc_order_unique_id', $order_unique_id, $order_id);
    update_field('goicc_order_first_name', $order_data['first_name'], $order_id);
    update_field('goicc_order_last_name', $order_data['last_name'], $order_id);
    update_field('goicc_order_email', $user_email, $order_id);

    update_field('goicc_order_status', array_key_first(goicc_get_order_statuses()), $order_id);
    update_field('goicc_payment_status', array_key_first(goicc_get_payment_statuses()), $order_id);
    update_field('goicc_product_type', $product_meta['goicc_product_type'][0], $order_id);

    if($order_data['payment_method']) 
        update_field('goicc_payment_method', $order_data['payment_method'], $order_id);
    if($order_data['product_id']) 
        update_field('goicc_order_product_id', $order_data['product_id'], $order_id);
    
    $order_products_with_prices = get_order_products_with_prices($order_data['product_id']);
    $products = $order_products_with_prices['products'];
    $prices = $order_products_with_prices['prices'];
    update_field('goicc_total_price', $prices['price'], $order_id);
    if($prices['price'] < $prices['full_price'])
        update_field('goicc_full_price', $prices['full_price'], $order_id);
    
    if($products){
        $products = array_map(function($product) {
            return array(
                'goicc_order_products_title' => $product['title'],
                'goicc_order_products_price' => $product['price'],
                'goicc_order_products_id' => $product['id'],
            );
        }, $products);
        update_field('goicc_order_products', $products, $order_id);
    }

    $is_company = ($order_data['is_company']) ? 1 : 0;
    update_field('is_company', $is_company, $order_id);

    p2p_type( 'user_to_order' )->connect( $post_author, $order_id, array(
        'date' => current_time('mysql')
    ) );

    $user_extra_fields_billing = goicc_get_user_extra_fields()['billing'];
    foreach($user_extra_fields_billing as $person_type_key => $person_type){
        if($person_type_key === 'company' && !$is_company) continue;
        foreach($person_type as $field_id => $val){
            if(!empty($order_data[$field_id])){
                update_field($field_id, $order_data[$field_id], $order_id);
            }
        }
    }

    do_action('goicc_create_order', $order_id, $post_author, $order_data, $product_data, $product_meta);

    return [
        'order_id' => $order_id,
        'order_unique_id' => $order_unique_id
    ];
}

/*function add_checkout_product_extra_details($user_id, $product_id, $product_meta){
    $product_types = goicc_get_product_types();
    $product_type = $product_meta['goicc_product_type'][0];
    $porduct_type_func = $product_types[$product_type]['checkout_action'];
    
    if(function_exists($porduct_type_func))
    return $porduct_type_func($user_id, $product_id, $product_meta);
    else
    return false;
}*/

function get_order_products_with_prices($product_id, $coupon_id = false){

    // @todo: de adaugat funcționalitatea de coupon. dacă intră ID-ul cuponului să să se mai adauge element la $products 
    // și să se modifice prețul final în funcție de valoarea cuponului și dacă se calculează din preul redus sau doar din prețul întreg
    // dacă cuponul se calculează din prețul întreg, să se șteargă rândul cu prețul redus în cazul în care produsul are reducerea lui.

    if(!$product_id) return false;
    $product_data = get_post($product_id, 'ARRAY_A');
    $product_meta = get_post_meta($product_id);
    $price = $product_meta['goicc_regular_price'][0];
    if($product_meta['goicc_sale_price'][0]) $price = $product_meta['goicc_sale_price'][0];
    $prices = [
        'price' => $price,
        'full_price' => $product_meta['goicc_regular_price'][0],
    ];

    $products[] = [
        'title' => $product_data['post_title'],
        'price' => $prices['full_price'],
        'id' => $product_id
    ];

    if($prices['full_price'] > $prices['price']){
        $products[] = [
            'title' => __("Product discount", 'goicc'), // @todo: add custom discout label for promotions periods (black friday, etc.)
            'price' => $prices['price'] - $prices['full_price']
        ];
    }

    $order_products_with_prices = [
        'products' => $products,
        'prices' => $prices
    ];

    return apply_filters( 'goicc_order_products_with_prices', $order_products_with_prices );
}