<?php

// P2P Post types connections
function my_connection_types() {
	p2p_register_connection_type( array(
		'name' => 'courses_to_videolessons',
		'from' => 'goicc_courses',
        'to' => 'goicc_videolessons',
        'cardinality' => 'one-to-many',
        'sortable' => 'any',
        'admin_column' => 'to',
        'admin_dropdown' => 'to',
        'admin_box' => array(
            'show' => 'any',
            'context' => 'advanced' // advanced or side
        )      
    ) );

    p2p_register_connection_type( array(
		'name' => 'posts_to_product',
		'from' => array('goicc_courses'),
        'to' => 'goicc_product',
        'cardinality' => 'one-to-many',
        'sortable' => 'any',
        'admin_column' => 'to',
        'admin_dropdown' => 'to',
        'admin_box' => array(
            'show' => 'any',
            'context' => 'advanced' // advanced or side
        )      
    ) );
    
    p2p_register_connection_type( array(
		'name' => 'user_to_order',
		'from' => 'user',
        'to' => 'goicc_order',
        'cardinality' => 'one-to-many',
        //'to_query_vars' => array( 'role' => 'editor' )
        'sortable' => 'any',
        'admin_column' => 'to',
        'admin_dropdown' => 'to',
        'admin_box' => array(
            'show' => 'any',
            'context' => 'side' // advanced or side
        ),
        'title' => array(
            'from' => __( 'Order', 'goicc' ),
            'to' => __( 'Customer', 'goicc' )
        ),
	) );
}
add_action( 'p2p_init', 'my_connection_types' );

// P2P personalisation fields
function append_date_to_candidate_title( $title, $post, $ctype ) {
	/*if ( 'courses_to_videolessons' == $ctype->name && 'goicc_courses' == $post->post_type ) {
		$title .= " (" . $post->_wp_page_template . ")";
    }*/
    if($post_thumbnail = get_the_post_thumbnail_url($post->ID, 'thumbnail')){
        $title = "<img src=".$post_thumbnail." style='width:30px; display: inline-block; margin-right: 5px; vertical-align: middle'>" . $title;
    }
	return $title;
}
add_filter( 'p2p_candidate_title', 'append_date_to_candidate_title', 10, 3 );
add_filter( 'p2p_connected_title', 'append_date_to_candidate_title', 10, 3 );