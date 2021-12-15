<?php 
$connected_products = new WP_Query( array(
    'connected_type' => 'posts_to_product',
    'connected_items' => $a['course'],
    'nopaging' => true,
) );
?>
<?php if ($connected_products->have_posts()) { ?>
    <div class="row products-list products-list-subscription align-items-stretch">
        <?php $i=0; while ($connected_products->have_posts()){ $connected_products->the_post(); ?>
            
            <div class="col-10 col-lg-4 col-md-8 offset-1 offset-md-2 offset-lg-0 <?php if($i > 2){echo 'col-lg-6 featured';} ?>">
                <?php get_template_part('template-parts/goicc_product/goicc_product-excerpt', 'subscription'); ?>
            </div>

            <style>
                .products-list .featured .shadow{
                    border: 1px solid #dc3545 !important;
                    box-shadow: 0 0.5rem 1rem rgb(220 53 69 / 15%) !important
                }
            </style>
            
        <?php $i++; } wp_reset_postdata(); ?>
    </div>
<?php } ?>