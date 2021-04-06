<?php 
// Post types and taxonomies
function create_posttypes_and_taxonomies() {
    register_post_type( 'goicc_courses',
        array(
            'labels' => array(
                'name' => __( 'Courses' ),
                'singular_name' => __( 'Courses' )
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields', 'revisions'),
            'has_archive' => false,
			'hierarchical' => false,
            'rewrite' => array('slug' => 'courses'),
        )
    );

    register_post_type( 'goicc_videolessons',
        array(
            'labels' => array(
                'name' => __( 'Video Lessons' ),
                'singular_name' => __( 'Video Lessons' )
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields', 'revisions'),
            'has_archive' => false,
			'hierarchical' => false,
            'rewrite' => array('slug' => 'videolessons'),
        )
    );

    register_post_type( 'goicc_product',
        array(
            'labels' => array(
                'name' => __( 'Products' ),
                'singular_name' => __( 'Product' )
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields', 'revisions'),
            'has_archive' => false,
            'publicly_queryable' => false,
			'hierarchical' => false,
        )
    );

    register_post_type( 'goicc_order',
        array(
            'labels' => array(
                'name' => __( 'Orders' ),
                'singular_name' => __( 'Order' )
            ),
            'public' => true,
            'supports' => array('title', 'author', 'custom-fields', 'revisions'),
            'has_archive' => false,
            'publicly_queryable' => false,
			'hierarchical' => false,
        )
    );

    /*register_taxonomy('goicc_languages',array('goicc_courses'), array(
        'hierarchical' => true,
        'has_archive' => true,
        'labels' => array(
            'name' => _x('Languages','taxonomy general name'),
            'singular_name' => _x('Languages','taxonomy general name'),
        ),
        'rewrite' => array( 'slug' => 'languages' ),
    ));*/

    /*register_taxonomy( 'goicc_order_status', array( 'goicc_order' ),
		array(
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'publicly_queryable'=> false,
			'query_var'         => true,
			//'rewrite'           => array( 'slug' => 'rooms' ),
			'labels'            => array(
				'name'              => _x( 'Order status', 'taxonomy general name' ),
				'singular_name'     => _x( 'Order status', 'taxonomy singular name' ),
			),
		)

	);*/

}
add_action( 'init', 'create_posttypes_and_taxonomies' );