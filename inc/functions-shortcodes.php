<?php

function goicc_shortcode_course_product( $atts ){
    $a = shortcode_atts( array(
        'course' => 0,
    ), $atts);
    
	ob_start();

    include(locate_template('inc/shortcodes/shortcode-course-products.php'));

    return ob_get_clean();
}
add_shortcode( 'course_product', 'goicc_shortcode_course_product' );

function goicc_shortcode_courses( $atts ){
    $a = shortcode_atts( array(
        'ids' => 0,
    ), $atts);
    
	ob_start();

    include(locate_template('inc/shortcodes/shortcode-courses.php'));

    return ob_get_clean();
}
add_shortcode( 'courses', 'goicc_shortcode_courses' );