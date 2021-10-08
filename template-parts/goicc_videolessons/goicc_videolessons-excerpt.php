<?php 
    global $i, $active_subscription;
    if($i || $i === 0){
        $post_title = $i+1 . '. ' . get_the_title();
    }else{
        $post_title = get_the_title();
    }
    if($active_subscription){
        $permalink = esc_url( get_permalink() );
    }else{
        $permalink = false;
    }
    // $videolessons_videos = get_field('goicc_videolessons_videos');
    // if($videolessons_videos){
    //     $duration = array_sum(array_column($videolessons_videos, 'goicc_videolessons_videos_duration'));
    // }
    $duration = get_field('goicc_videolessons_duration');
?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <div class="row align-items-center">
        <div class="col-5 col-md-4 col-lg-3">
            <a <?php if($permalink){?> href="<?php echo $permalink; ?>" <?php } ?> title="<?php echo $post_title; ?>" class="bg-img bg-cover p-ar-3x2 lazy" data-src="<?php if($post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium')){ echo $post_thumbnail; } ?>">

            </a>
        </div>
        <div class="col-7 col-md-8 col-lg-9">
            <header class="entry-header">
                <h2 class="title h5 font-weight-bold">
                    <a <?php if($permalink){?> href="<?php echo $permalink; ?>" <?php } ?> class="text-dark" title="<?php echo $post_title; ?>">
                        <?php echo $post_title; ?>
                    </a>
                </h2>
            </header>
            <div class="entry-summary d-none d-md-block">
                <?php the_excerpt(); ?>
            </div>
            <div class="meta mt-3">
                <?php if($duration){ ?>
                    <span class="font-weight-light mr-2">
                        <?php echo seconds_to_time($duration, true); ?>
                    </span>
                <?php } ?>
            </div>
        </div>
    </div>

    <hr class="my-4">
</article>
<?php 
//unset($duration);