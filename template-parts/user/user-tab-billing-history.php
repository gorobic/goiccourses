<?php
global $user_id;

if(isset($_GET) && isset($_GET['order_id'])){ 
    if($order_id = check_order($_GET['order_id'])){

        $author_id = intval(
            get_users( array(
                'connected_type' => 'user_to_order',
                'connected_items' => $order_id
            )  )[0]->ID
        );
        //$author_id = intval(get_post_field( 'post_author', $order_id )) // post author

        if($author_id === $user_id){
            $order_details = true;
        }
    }
}

if(isset($order_details) && $order_details){
    //$order_meta = get_post_meta($order_id);
    
    ?>
    <h4>
        <?php _e('Order details','goicc'); ?>
    </h4>
    <?php

    $invoice_table = generate_invoice_table($order_id);
    // aici vine detaliile comenzii.

    echo $invoice_table['table'];

}else{ ?>

    <h4>
        <?php _e('Billing history','goicc'); ?>
    </h4>

    <?php
    $args = array(
        'nopaging' => true,
        'suppress_filters' => false,
        'post_type' => array( 'goicc_order' ),
        'connected_type' => 'user_to_order',
        'connected_items' => $user_id,
        //'author' => $user_id, // alternativa la posts2posts connection
    );

    $orders = new WP_Query($args); ?>

    <?php if ($orders->have_posts()) { 
        $order_statuses = goicc_get_order_statuses();
        ?>
        <div class="table-responsive">
            <table class="table table-striped mt-4 small">
                <thead>
                    <tr>
                        <th>
                            <?php _e('Date','goicc'); ?>
                        </th>
                        <th>
                            <?php _e('Title','goicc'); ?>
                        </th>
                        <th>
                            <?php _e('Total','goicc'); ?>
                        </th>
                        <th>
                            <?php _e('Status','goicc'); ?>
                        </th>
                        <th>
                            
                        </th>
                    </tr>
                </thead>
                <?php $i=0; while ($orders->have_posts()){ 
                    $orders->the_post();
                    $order_meta = get_post_meta(get_the_ID());
                    $order_id = get_the_ID();
                    ?>

                    <tr>
                        <td>
                            <?php echo get_the_date('d.m.Y'); ?>
                        </td>
                        <td>
                            <?php the_title(); ?>
                            <div id="product_extra_details" class="small text-muted">
                                <?php do_action('goicc_billing_history_product_extra_details', $user_id, $order_meta->ID, $order_meta); ?>
                            </div>
                        </td>
                        <td>
                            <?php 
                            $total_price = $order_meta['goicc_total_price'][0];
                            $full_price = $order_meta['goicc_full_price'][0];
                            
                            if($full_price && $total_price < $full_price)
                                echo '<del class="small text-muted d-block text-nowrap">' . set_currency($full_price) . '</del> ';
                            
                            echo '<span class="text-nowrap">' . set_currency($total_price) . '</span>';
                            ?>

                        </td>
                        <td>
                            <span class="small">
                                <?php 
                                    $order_status = $order_meta['goicc_order_status'][0]; 
                                    echo $order_statuses[$order_status];
                                ?>
                            </span>
                        </td>
                        <td>
                            <?php 
                            $query_string = [];
                            parse_str($_SERVER['QUERY_STRING'], $query_string);
                            $query_string['order_id'] = $order_id . '-' . $order_meta['goicc_order_unique_id'][0];
                            $result_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '?' . http_build_query($query_string);
                            ?>
                            <a href="<?php echo $result_url; ?>" class="btn btn-sm btn-outline-primary m-1">
                                <?php _e('View','goicc'); ?>
                            </a>
                            <?php do_action('goicc_billing_history_buttons', $order_id, $order_meta); ?>
                        </td>
                    </tr>

                    <?php
                $i++; } wp_reset_postdata(); ?>
            </table>
        </div>
    <?php } ?>
<?php } ?>