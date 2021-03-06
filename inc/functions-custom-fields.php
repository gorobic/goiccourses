<?php 

$payment_method = goicc_get_payment_method();
$payment_method = array_combine(array_keys($payment_method), array_column($payment_method, 'title'));

$product_types = goicc_get_product_types();
$product_types = array_combine(array_keys($product_types), array_column($product_types, 'title'));


// Order START
$order_fields = array(
	array(
		'key' => 'field_order_status',
		'label' => 'Order status',
		'name' => 'goicc_order_status',
		'type' => 'select',
		'instructions' => '',
		'required' => 1,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '50',
			'class' => '',
			'id' => '',
		),
		'choices' => goicc_get_order_statuses(),
		'default_value' => array_key_first(goicc_get_order_statuses()),
		'allow_null' => 0,
		'multiple' => 0,
		'ui' => 0,
		'return_format' => 'value',
		'ajax' => 0,
		'placeholder' => '',
	),
	array(
		'key' => 'field_order_payment_status',
		'label' => 'Payment status',
		'name' => 'goicc_payment_status',
		'type' => 'select',
		'instructions' => '',
		'required' => 1,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '50',
			'class' => '',
			'id' => '',
		),
		'choices' => goicc_get_payment_statuses(),
		'default_value' => array_key_first(goicc_get_payment_statuses()),
		'allow_null' => 0,
		'multiple' => 0,
		'ui' => 0,
		'return_format' => 'value',
		'ajax' => 0,
		'placeholder' => '',
	),
	array(
		'key' => 'field_order_payment_method',
		'label' => 'Payment method',
		'name' => 'goicc_payment_method',
		'type' => 'text',
		'instructions' => 'Available: '. implode(', ', array_keys($payment_method)),
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		//'choices' => $payment_method,
		'default_value' => false,
		'allow_null' => 1,
		'multiple' => 0,
		'ui' => 0,
		'return_format' => 'value',
		'ajax' => 0,
		'placeholder' => '',
	),
	array(
		'key' => 'field_order_product_id',
		'label' => 'Product ID',
		'name' => 'goicc_order_product_id',
		'type' => 'number',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	),
	array(
		'key' => 'field_order_total_price',
		'label' => 'Total price',
		'name' => 'goicc_total_price',
		'type' => 'number',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '50',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	),
	array(
		'key' => 'field_order_full_price',
		'label' => 'Full price (without discount)',
		'name' => 'goicc_full_price',
		'type' => 'number',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '50',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	),
	array(
		'key' => 'field_goicc_order_products',
		'label' => 'Order products',
		'name' => 'goicc_order_products',
		'type' => 'repeater',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'collapsed' => '',
		'min' => 0,
		'max' => 0,
		'layout' => 'table',
		'button_label' => '',
		'sub_fields' => array(
			array(
				'key' => 'field_goicc_order_products_title',
				'label' => 'Title',
				'name' => 'goicc_order_products_title',
				'type' => 'text',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_goicc_order_products_id',
				'label' => 'ID',
				'name' => 'goicc_order_products_id',
				'type' => 'number',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array(
				'key' => 'field_goicc_order_products_price',
				'label' => 'Price',
				'name' => 'goicc_order_products_price',
				'type' => 'number',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
		),
	),
	array(
		'key' => 'field_order_product_type',
		'label' => 'Product type',
		'name' => 'goicc_product_type',
		'type' => 'select',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'choices' => $product_types,
		'default_value' => array_key_first($product_types),
		'allow_null' => 0,
		'multiple' => 0,
		'ui' => 0,
		'return_format' => 'value',
		'ajax' => 0,
		'placeholder' => '',
	),
	array(
		'key' => 'field_order_subscription_months',
		'label' => 'Subscription Months',
		'name' => 'goicc_subscription_months',
		'type' => 'number',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '20',
			'class' => '',
			'id' => '',
		),
		'default_value' => '1',
		'placeholder' => '',
		'prepend' => '',
		'append' => 'months',
		'maxlength' => '',
	),
	array(
		'key' => 'field_order_subscription_start_date',
		'label' => 'Subscription Start Date',
		'name' => 'goicc_subscription_start_date',
		'type' => 'date_picker',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '40',
			'class' => '',
			'id' => '',
		),
		'display_format' => 'd.m.Y',
		'return_format' => 'Ymd',
		'first_day' => 1,
	),
	array(
		'key' => 'field_order_subscription_end_date',
		'label' => 'Subscription End Date',
		'name' => 'goicc_subscription_end_date',
		'type' => 'date_picker',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '40',
			'class' => '',
			'id' => '',
		),
		'display_format' => 'd.m.Y',
		'return_format' => 'Ymd',
		'first_day' => 1,
	),
	array(
		'key' => 'field_order_update_and_send_email',
		'label' => 'Update dates and send email (if Order status = Completed)',
		'name' => 'goicc_order_update_and_send_email',
		'type' => 'true_false',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'message' => 'If is checked, subscriptions dates will updated and user will recive email about access',
		'default_value' => 1,
		'ui' => 1,
		'ui_on_text' => '',
		'ui_off_text' => '',
	),
	array(
		'key' => 'field_order_unique_id',
		'label' => 'Unique ID',
		'name' => 'goicc_order_unique_id',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	),
	array(
		'key' => 'field_order_first_name',
		'label' => 'First Name',
		'name' => 'goicc_order_first_name',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '50',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	),
	array(
		'key' => 'field_order_last_name',
		'label' => 'Last Name',
		'name' => 'goicc_order_last_name',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '50',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	),
	array(
		'key' => 'field_order_email',
		'label' => 'Email',
		'name' => 'goicc_order_email',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	),
	array(
		'key' => 'field_is_company',
		'label' => 'Is company',
		'name' => 'is_company',
		'type' => 'true_false',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'message' => 'Is company',
		'default_value' => 0,
		'ui' => 1,
		'ui_on_text' => '',
		'ui_off_text' => '',
	),
);
$user_extra_fields_billing = goicc_get_user_extra_fields()['billing'];
foreach($user_extra_fields_billing as $key_1 => $val_1){
	if($key_1 === 'company'){
		$conditional = array(
			array(
				array(
					'field' => 'field_is_company',
					'operator' => '==',
					'value' => '1',
				),
			),
		);
	}else{
		$conditional = 0;
	}
	$order_fields[] = array(
		'key' => 'field_order_'.$key_1,
		'label' =>  strtoupper($key_1),
		'name' => '',
		'type' => 'message',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => $conditional,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'message' => '',
		'new_lines' => 'wpautop',
		'esc_html' => 0,
	);

	foreach($val_1 as $key_2 => $val_2){
		$order_fields[] = array(
			'key' => 'field_order_'.$key_2,
			'label' => $val_2['title'],
			'name' => $key_2,
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => $conditional,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		);
	};
}
// Order END

// Product START
$product_fields = array(
	array(
		'key' => 'field_product_display_title',
		'label' => 'Display Title',
		'name' => 'goicc_display_title',
		'type' => 'text',
		'instructions' => '',
		'required' => 1,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	),
	array(
		'key' => 'field_product_type',
		'label' => 'Product type',
		'name' => 'goicc_product_type',
		'type' => 'select',
		'instructions' => '',
		'required' => 1,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'choices' => $product_types,
		'default_value' => array_key_first($product_types),
		'allow_null' => 0,
		'multiple' => 0,
		'ui' => 0,
		'return_format' => 'value',
		'ajax' => 0,
		'placeholder' => '',
	),
	array(
		'key' => 'field_product_subscription_months',
		'label' => 'Subscription Months',
		'name' => 'goicc_subscription_months',
		'type' => 'number',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '1',
		'placeholder' => '',
		'prepend' => '',
		'append' => 'months',
		'maxlength' => '',
	),
	array(
		'key' => 'field_product_regular_price',
		'label' => 'Regular price',
		'name' => 'goicc_regular_price',
		'type' => 'number',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '50',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => 'RON',
		'maxlength' => '',
	),
	array(
		'key' => 'field_product_sale_price',
		'label' => 'Sale price',
		'name' => 'goicc_sale_price',
		'type' => 'number',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '50',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => 'RON',
		'maxlength' => '',
	),
);

// Product END


if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5fd3a8272583e',
	'title' => 'Order details',
	'fields' => $order_fields,
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'goicc_order',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal', // normal or side
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_product_1',
	'title' => 'Product details',
	'fields' => $product_fields,
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'goicc_product',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal', // normal or side
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

// Courses
acf_add_local_field_group(array(
	'key' => 'group_5fc9134b8f888',
	'title' => 'Courses',
	'fields' => array(
		array(
			'key' => 'field_5fc91642a85b9',
			'label' => 'Featured video ID',
			'name' => 'goicc_courses_featured_video_id',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5fc916498340',
			'label' => 'Preview video ID',
			'name' => 'goicc_courses_preview_video_id',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5fc91354a85b8',
			'label' => 'Duration',
			'name' => 'goicc_courses_duration',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'in seconds',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'goicc_courses',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

// Video Lessons
acf_add_local_field_group(array(
	'key' => 'group_5fc9008fd23a6',
	'title' => 'Video lessons',
	'fields' => array(
		array(
			'key' => 'field_5fc9135878768',
			'label' => 'Duration',
			'name' => 'goicc_videolessons_duration',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'in seconds',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5fc900d062c45',
			'label' => 'Videos',
			'name' => 'goicc_videolessons_videos',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => 'field_5fc9013a62c47',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5fc9013a62c47',
					'label' => 'Title',
					'name' => 'goicc_videolessons_videos_title',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5fc9010862c46',
					'label' => 'Video ID',
					'name' => 'goicc_videolessons_videos_id',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				// array(
				// 	'key' => 'field_5fc9015762c48',
				// 	'label' => 'Duration',
				// 	'name' => 'goicc_videolessons_videos_duration',
				// 	'type' => 'number',
				// 	'instructions' => '',
				// 	'required' => 0,
				// 	'conditional_logic' => 0,
				// 	'wrapper' => array(
				// 		'width' => '',
				// 		'class' => '',
				// 		'id' => '',
				// 	),
				// 	'default_value' => '',
				// 	'placeholder' => 'in seconds',
				// 	'prepend' => '',
				// 	'append' => '',
				// 	'min' => '',
				// 	'max' => '',
				// 	'step' => '',
				// ),
			),
		),
		array(
			'key' => 'field_5fc90e7d6495c',
			'label' => 'References',
			'name' => 'goicc_videolessons_references',
			'type' => 'gallery',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'medium',
			'insert' => 'append',
			'library' => 'all',
			'min' => '',
			'max' => '',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5fc9114a3af93',
			'label' => 'Homework',
			'name' => 'goicc_videolessons_homework',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'goicc_videolessons',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;


function my_page_columns($columns){
    $columns['goicc_order_status'] = 'Order status';
    return $columns;
}

function my_custom_columns($column){
    global $post;
    
    if ($column === 'goicc_order_status') {
		$field_obj = get_field_object( "goicc_order_status", $post->ID );
		switch ($field_obj['value']) {
			case 'completed':
				$color = '#00a32a';
				break;
			case 'cancelled':
			case 'refunded':
				$color = '#d63638';
				break;
			case 'failed':
				$color = '#dba617';
				break;
			default:
				$color = ''; // #72aee6 - info
		}
		
		echo '<span style="color: ' . $color . '">' . $field_obj['choices'][ $field_obj['value'] ] . '</span>';
    }
    else {
         echo '';
    }
}

add_action("manage_goicc_order_posts_custom_column", "my_custom_columns");
add_filter("manage_goicc_order_posts_columns", "my_page_columns");