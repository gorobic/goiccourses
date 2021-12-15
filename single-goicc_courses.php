<?php get_header(); ?>

<?php if ( have_posts() ) { 
    while ( have_posts() ) { the_post(); 
    
        $connected_videolessons = new WP_Query( array(
            'connected_type' => 'courses_to_videolessons',
            'connected_items' => get_queried_object(),
            'nopaging' => true,
        ) );

        global $user_id, $registration_url, $login_url;
        $active_subscription = check_active_subscription_to_course($user_id, get_the_ID());
        // $active_subscription = get_subscription_data($user_id, get_the_ID())['active'];

    ?>
        </div>

        <div class="bg-dark text-light border-top border-gray-900">
            <div class="container">
                <div class="position-relative">
                    <div class="row position-relative course-main">
                        <div class="col-sm-9 col-lg-6">
                            <article <?php post_class('py-5'); ?> id="post-<?php the_ID(); ?>">
                                <header class="entry-header">
                                    <h1 class="title">
                                        <?php the_title(); ?>
                                    </h1>
                                </header>

                                <div class="entry">
                                    <?php the_content(); ?>
                                </div>
                                <div class="course-details mt-4">
                                    <?php if($connected_videolessons->have_posts()){ ?>
                                        <span class="font-weight-light mr-3">
                                            <span class="goicicons-chapters mr-1"></span> <?php echo chapters_number_format($connected_videolessons->found_posts); ?>
                                        </span>
                                    <?php } ?>
                                    <?php if($duration = get_field('goicc_courses_duration')){ ?>
                                        <span class="font-weight-light mr-3">
                                            <?php echo seconds_to_time($duration, true); ?>
                                        </span>
                                    <?php } ?>
                                </div>
                                <div class="course-buttons mt-4">
                                    <a href="#course-content" class="btn btn-primary btn-lg rounded-0 mr-2 font-weight-light text-capitalize">
                                        <?php _e('Start this course','goicc'); ?>
                                    </a>
                                    
                                    <?php 
                                    $featured_video_id = get_field('goicc_courses_featured_video_id'); 
                                    $preview_video_id = get_field('goicc_courses_preview_video_id'); 
                                    if($preview_video_id){ 
                                    ?>
                                        <a href="https://player.vimeo.com/video/<?php echo $preview_video_id; ?>?autoplay=1&loop=1&autopause=0&byline=0&title=0" class="btn text-light font-weight-light btn-lg" data-fancybox>
                                            <span class="goicicons-play-square mr-2"></span> <?php _e('Preview','goicc'); ?>
                                        </a>
                                    <?php } ?>
                                </div>

                            </article>
                        </div>
                    </div>
                    <div class="course-featured bg-img bg-cover lazy" data-videobg data-ratio="56.25" data-src="<?php if($post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large')){ echo $post_thumbnail; } ?>">
                        <?php if($featured_video_id){ ?>
                            <iframe src="https://player.vimeo.com/video/<?php echo $featured_video_id; ?>?background=1&autoplay=1&loop=1&autopause=0&byline=0&title=0"
           frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen"></iframe>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
        <div id="course-content">
            <?php if($active_subscription){ ?>                    
                <?php if ($connected_videolessons->have_posts()) { ?>
                    <section class="videolessons-list my-5">
                        <?php $i=0; while ($connected_videolessons->have_posts()){ $connected_videolessons->the_post();
                                
                            get_template_part('template-parts/goicc_videolessons/goicc_videolessons', 'excerpt');
                            
                        $i++; } wp_reset_postdata(); ?>
                    </section>
                <?php } ?>
            <?php }else{ ?>
                <?php if ($connected_videolessons->have_posts()) { ?>
                    <section class="videolessons-list my-5 placeholder">
                        <?php $i=0; while ($connected_videolessons->have_posts()){ $connected_videolessons->the_post();
                                
                            get_template_part('template-parts/goicc_videolessons/goicc_videolessons', 'excerpt');
                            
                            if($i >= 0) break;
                            
                        $i++; } wp_reset_postdata(); ?>
                    </section>
                <?php } ?>

                <div class="my-4 my-md-5">
                    <div class="bg-gray-200 border border-gray-400 rounded-lg p-5">
                        <div class="text-center">
                            <div class="h2">
                                <?php _e('Ready to watch the whole course?','goicc'); ?>
                            </div>
                            <div class="mb-4">
                                <?php _e('Subscribe to this course! Choose a period that is more convenient for you.','goicc'); ?>
                            </div>
                            <div class="mb-4">
                                <div class="row justify-content-center">
                                    <div class="col-md-10 col-lg-6">
                                        <div class="bg-danger text-light border border-danger px-4 py-3">
                                        Reduceri de sărbători în perioada <strong>19 - 29 decembrie 2021</strong>! Beneficiază de o perioadă mai mare de acces, la un preț redus!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo do_shortcode('[course_product course='. get_the_ID() .']'); ?>
                    </div>
                </div>
                <?php if (!is_user_logged_in()) { ?>
                    <div class="my-4 my-md-5 text-center text-muted">
                        <?php printf( 
                            __( 
                                'if you already have access to this course, please <a href="%s">Log In</a>. Or maybe you want to <a href="%s">register</a>?', 
                                'goicc' 
                            ), 
                            $login_url,
                            $registration_url
                        ); ?>
                    </div>
                <?php } ?>

            <?php } ?>
        </div>

    <?php } 
}else{ 
?>

    <p>
        <?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?>
    </p>

<?php } ?>

<?php get_footer(); ?>