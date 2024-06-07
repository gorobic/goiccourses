<?php 
$meta = get_post_meta(get_the_ID()); 
$post_title = get_the_title();
//global $checkout_page_permalink;
?>
<div class="py-row h-100">
    <div class="shadow bg-white border-top border-secondary h-100">
        <a href="<?php echo esc_url( get_permalink() ); ?>" class="h-100 d-block" title="<?php echo $post_title; ?>"> 
            <div class="bg-img bg-cover position-relative p-ar-3x2 lazy" data-src="<?php if($post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium')){ echo $post_thumbnail; } ?>">
                <?php if($duration = get_field('goicc_courses_duration')){ ?>
                    <div class="course-details">
                        <span class="font-weight-light">
                            <?php echo seconds_to_time($duration, true); ?>
                        </span>
                    </div>
                <?php } ?>
            </div>
            <div class="entry p-3">
                <h4 class="title m-0">
                    <?php echo $post_title; ?>
                </h4>
            </div>
        </a>
    </div>
</div>