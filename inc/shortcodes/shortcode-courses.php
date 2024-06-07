<?php 
$courses = new WP_Query( array(
    'post_type' => 'goicc_courses',
    'include' => explode(',', strval($a['ids'])),
    'nopaging' => true,
) );
?>
<?php if ($courses->have_posts()) { ?>
    <div class="row courses-list align-items-stretch">
        <?php $i=0; while ($courses->have_posts()){ $courses->the_post(); ?>
            
            <div class="col-10 col-lg-4 col-md-8 offset-1 offset-md-2 offset-lg-0">
                <?php get_template_part('template-parts/goicc_courses/goicc_courses', 'excerpt'); ?>
            </div>
            
        <?php $i++; } wp_reset_postdata(); ?>
    </div>
<?php } ?>