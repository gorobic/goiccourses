<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title><?php wp_title(); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
    if (get_the_ID()) {
        $built_with_elementor = (Elementor\Plugin::instance()->db->is_built_with_elementor(get_the_ID())) ? true : false;
    } else {
        $built_with_elementor = false;
    }
    define("BUILT_WITH_ELEMENTOR", $built_with_elementor);

    // or by checking directly
    // $elementor_page = get_post_meta( get_the_ID(), '_elementor_edit_mode', true );
    // if ( ! ! $elementor_page ) {

    // }
    ?>
    <div id="wrap">
        <?php get_template_part('template-parts/navigation/navigation', 'top'); ?>
        <?php if (!BUILT_WITH_ELEMENTOR) { ?>
            <div class="container-xl">
            <?php } ?>