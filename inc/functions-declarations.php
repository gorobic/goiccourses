<?php 

function goicc_get_order_statuses() {
    $order_statuses = array( // Details: https://docs.woocommerce.com/document/managing-orders/
      'pending'    => _x( 'Pending payment', 'Order status', 'goicc' ), // Order received, no payment initiated
      'processing' => _x( 'Processing', 'Order status', 'goicc' ), // Payment received (paid) and stock has been reduced; order is awaiting fulfillment
      'on-hold'    => _x( 'On hold', 'Order status', 'goicc' ), // Awaiting payment – stock is reduced, but you need to confirm payment
      'completed'  => _x( 'Completed', 'Order status', 'goicc' ), // Order fulfilled and complete – requires no further action
      'cancelled'  => _x( 'Cancelled', 'Order status', 'goicc' ), // Canceled by an admin or the customer – stock is increased, no further action required
      'refunded'   => _x( 'Refunded', 'Order status', 'goicc' ), // Refunded by an admin – no further action required
      'failed'     => _x( 'Failed', 'Order status', 'goicc' ), // Payment failed or was declined (unpaid)
    );
    return apply_filters( 'goicc_order_statuses', $order_statuses );
  }
   

function goicc_get_payment_statuses() {
    $payment_statuses = array(
        'unpaid'    => _x( 'Unpaid', 'Payment status', 'goicc' ),
        'paid'      => _x( 'Paid', 'Payment status', 'goicc' ),
    );
    return apply_filters( 'goicc_payment_statuses', $payment_statuses );
}

function goicc_get_payment_method() {
    $payment_method = array(
        'cod'   => [
            'title' => _x( 'Plata la sediu', 'Payment method', 'goicc' ),
            'desc' => _x( 'Lorem ipsum dolor sit amet.', 'Payment method description', 'goicc' ),
        ],
        'bank_transfer'   => [
            'title' => _x( 'Bank transfer', 'Payment method', 'goicc' ),
            'desc' => _x( 'On the next page you will see the bank details on which you are asked to make the transfer.', 'Payment method description', 'goicc' ),
        ],
    );
    return apply_filters( 'goicc_payment_method', $payment_method );
}

function goicc_get_product_types() {
    $product_types = array(
        'subscription'    => [
            'title' => _x( 'Subscription', 'Product types', 'goicc' ),
        ],
        //'gift_card'      => 'subscription'    => [
        //     'title' => _x( 'Gift card', 'Product types', 'goicc' ),
        // ],
        //'offline_lessons'      => 'subscription'    => [
        //     'title' => _x( 'Offline lessons', 'Product types', 'goicc' ),
        // ],
    );
    return apply_filters( 'goicc_product_types', $product_types );
}

function goicc_get_user_account_tabs() {
    $user_account_tabs = array(
        'account' => _x('Account', 'User account tab', 'goicc'), 
        //'courses' => _x('Courses', 'User account tab', 'goicc'), 
        'billing' => _x('Billing info', 'User account tab', 'goicc'), 
        'billing-history' => _x('Billing history', 'User account tab', 'goicc')
    );
    return apply_filters( 'goicc_user_account_tabs', $user_account_tabs );
}

function goicc_get_user_extra_fields() {
    $user_extra_fields = [
        'billing' => [
            'company' => [
                'company_name' => [
                    'title' => __('Company name','goicc'),
                    'required' => true,
                    'desc' => __('','goicc')
                ],
                'vat_code' => [
                    'title' => __('VAT Code','goicc'),
                    'required' => true,
                    'desc' => __('','goicc')
                ],
                'nr_reg_com' => [
                    'title' => __('Nr. Ord. Reg. Com.', 'goicc'),
                    'required' => true,
                    'desc' => __('','goicc')
                ],
                'iban' => [
                    'title' => __('IBAN','goicc'),
                    'required' => true,
                    'desc' => __('','goicc')
                ],
                'bank_name' => [
                    'title' => __('Bank name','goicc'),
                    'required' => true,
                    'desc' => __('','goicc')
                ],
            ],
            'general' => [
                'phone' => [
                    'title' => __('Phone number','goicc'),
                    'required' => true,
                    'desc' => __('','goicc')
                ],
                'country' => [
                    'title' => __('Country','goicc'),
                    'required' => true,
                    'desc' => __('','goicc')
                ],
                'state' => [
                    'title' => __('State/Province','goicc'),
                    'required' => true,
                    'desc' => __('','goicc')
                ],
                'city' => [
                    'title' => __('City','goicc'),
                    'required' => true,
                    'desc' => __('','goicc')
                ],
                'address' => [
                    'title' => __('Address','goicc'),
                    'required' => true,
                    'desc' => __('','goicc')
                ],
                'postal_code' => [
                    'title' => __('Postal code','goicc'),
                    'required' => false,
                    'desc' => __('','goicc')
                ],
            ],
        ],
    ];
    return apply_filters( 'goicc_user_extra_fields', $user_extra_fields );
}

$user_id = get_current_user_id();
$registration_url = wp_registration_url();
$login_url = wp_login_url(site_url( $_SERVER['REQUEST_URI'] ));
$checkout_page_id = get_theme_mod( 'goicc_checkout_page' );
// $checkout_page_permalink = get_the_permalink( $checkout_page_id );
define('CHECKOUT_PAGE_PERMALINK', get_the_permalink( $checkout_page_id ));
$thankyou_page_id = get_theme_mod( 'goicc_thankyou_page' );
$thankyou_page_permalink = get_the_permalink( $thankyou_page_id );
