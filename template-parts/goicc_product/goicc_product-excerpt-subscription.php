<?php 
$meta = get_post_meta(get_the_ID()); 
global $checkout_page_permalink;
?>
<div class="py-row h-100">
    <div class="shadow bg-white border-top border-secondary h-100 d-flex flex-column justify-content-between">
        <div>
            <div class="px-3 my-3">
                <div class=" text-uppercase text-center font-weight-bold">
                    <?php echo $months = $meta['goicc_subscription_months'][0]; ?> <?php echo _n( 'month', 'months', $months, 'goicc' ); ?>
                </div>
                <div class="text-center">
                    <?php echo render_price($meta['goicc_regular_price'][0], $meta['goicc_sale_price'][0]); ?>
                </div>
                <hr class="">
            </div>
            <div class="px-3 my-3">
                <div class="text-center h5 mb-3">
                    <?php echo $meta['goicc_display_title'][0]; ?>
                </div>
                <div>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <div class="px-3 mb-3">
            <a href="<?php echo $checkout_page_permalink . '?id='. get_the_ID(); ?>" rel="nofollow" class="btn btn-outline-primary rounded-0 d-block">
                <?php _e('Get started','goicc'); ?>
            </a>
        </div>
    </div>
</div>