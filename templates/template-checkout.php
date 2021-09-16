<?php /* Template Name: Checkout */ 

global $user_id;

// Redirect after submit
if ( isset($_GET) && isset($_GET['status']) ){
    global $thankyou_page_permalink;

    do_action('goicc_after_submit_return');

    if($_GET['status'] === 'success' && isset($_GET['order_id']) ){
        $destination = get_ty_page_url($_GET['order_id']);
        header('Location: '.$destination);
    }
    die();
}

$form_id = 'checkout-form';
if(!is_user_logged_in()){
    $form_id = 'dummy-form';

    ob_start();
    get_template_part( 'template-parts/user/user-alert', 'authentication' );
    $form_overlay = ob_get_clean();
}

if( isset($_GET['id']) && !empty($_GET['id']) ){
    $product_id = $_GET['id'];
    $product_meta = get_post_meta($product_id); 
    $order_products_with_prices = get_order_products_with_prices($product_id);
}

// If user have active subscription to this course, redirect to course page. User can not subscribe again to active course.
$connected_courses = get_posts( array(
    'connected_type' => 'posts_to_product',
    'connected_items' => $product_id,
    'nopaging' => true,
    'suppress_filters' => false
) );
if($connected_courses){
    $connected_course = $connected_courses[0];
    $course_id = $connected_course->ID;
}
$subscription_data = get_subscription_data($user_id, $course_id);
if($subscription_data['active'] || $subscription_data['future']){
    $course_permalink = get_the_permalink($course_id);

    header('Location: '.$course_permalink);
}

get_header(); ?>

<!-- Început de Loop. -->
<?php if ( have_posts() ) { 
    while ( have_posts() ) { the_post(); ?>
        <article <?php post_class('mb-4 mt-4'); ?> id="page-<?php the_ID(); ?>">
            <header class="entry-header border-bottom pb-4 mb-4">
                <h1 class="title m-0">
                    <?php the_title(); ?>
                </h1>
            </header>

            <div class="entry">
                <?php the_content(); ?>
            </div>
        </article>
    <? } 
}
?>

<div id="checkout" data-product="<?php if(isset($_GET['id'])){echo $_GET['id']; } ?>" data-user="<?php echo $user_id; ?>">
    <form method="post" id="<?php echo $form_id; ?>" class="my-5 position-relative" action="<?php echo home_url().$_SERVER['REQUEST_URI']; ?>">
        <?php if($form_overlay) echo $form_overlay; ?>
        <div class="row">
            <div class="col-lg-5 order-lg-last">
                <div id="order_review" class="mb-4">
                    <div class="h4">
                        <?php _e("Your order", 'goicc'); ?>
                    </div>
                    <table class="table table-bordered bg-light" id="order_review_table">
                        <tbody>
                            <?php $i= 0; foreach($order_products_with_prices['products'] as $item){ ?>
                                <tr>
                                    <td>
                                        <?php echo $item['title']; ?>
                                        <?php if($i === 0){ ?>
                                            <div id="product_extra_details" class="small text-muted">
                                                <?php do_action('goicc_checkout_product_extra_details', $user_id, $product_id, $product_meta); ?>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <td class="price">
                                        <?php echo set_currency($item['price']); ?>
                                    </td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                        <tfoot style="font-weight: bold">
                            <tr>
                                <td>
                                    <?php _e("Total", 'goicc'); ?>
                                </td>
                                <td id="order_price">
                                    <?php echo set_currency($order_products_with_prices['prices']['price']); ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-lg-7">

                <div class="h4">
                    <?php _e("Billing details", 'goicc'); ?>
                </div>
                <p class="mt-4">
                    <input type="checkbox" name="is_company" value="1" id="is_company"
                        <?php if(is_user_logged_in() && get_the_author_meta( 'is_company', $user_id )){echo 'checked';}?> />
                    <label
                        for="is_company"><?php _e("Persoană juridică", 'goicc'); get_the_author_meta( 'is_company', $user_id ); ?></label></label>
                </p>

                <div class="row">
                    <div class="col-lg-6">
                        <p class="form-username">
                            <label for="first_name"><?php _e('First Name', 'profile'); ?> *</label>
                            <input class="text-input form-control" name="first_name" type="text" id="first_name"
                                value="<?php if(is_user_logged_in()){ the_author_meta( 'first_name', $user_id ); } ?>" required />
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="form-username">
                            <label for="last_name"><?php _e('Last Name', 'profile'); ?> *</label>
                            <input class="text-input form-control" name="last_name" type="text" id="last_name"
                                value="<?php if(is_user_logged_in()){ the_author_meta( 'last_name', $user_id ); } ?>" required />
                        </p>
                    </div>
                </div>

                <?php
                $user_extra_fields = goicc_get_user_extra_fields();
                foreach($user_extra_fields['billing'] as $person_type_key => $person_type){
                    if($person_type_key === 'company'){
                        echo '<div class="only-company">';
                    }

                    foreach($person_type as $field => $val){
                        ?>
                        <p class="form-field">
                            <label for="<?php echo $field; ?>"><?php echo $val['title']; ?> <?php if($val['required']){ echo '*'; } ?></label>
                            <input class="text-input form-control" name="<?php echo $field; ?>" type="text" id="<?php echo $field; ?>"
                                value="<?php if(is_user_logged_in()){ the_author_meta( $field, $user_id ); } ?>"
                                <?php if($val['required']){ echo 'required'; } ?> />
                            <?php if($val['desc']){ ?>
                                <small class="form-text text-muted"><?php echo $val['desc']; ?></small>
                            <?php } ?>
                        </p>
                        <?php
                    }

                    if($person_type_key === 'company'){
                        echo '</div>';
                    }
                } ?>
                
                <?php $payment_method = goicc_get_payment_method();
                if($payment_method){
                    $payment_method_count = count($payment_method);
                    ?>
                    <div id="payment-method" class="border boder-gray-300 bg-light p-3 mb-3">
                        <div class="h4">
                            <?php echo _n( 'Payment Method', 'Payment Methods', $payment_method_count, 'goicc' ) ?>
                        </div>
                        <?php if($payment_method_count === 1){ $payment_method = array_shift($payment_method); ?>
                            <input type="hidden" name="payment_method" value="<?php echo array_key_first($payment_method); ?>">
                            <div class="font-weight-bold">
                                <?php echo $payment_method['title']; ?>
                            </div>
                            <div>
                            <?php echo $payment_method['desc']; ?>
                            </div>
                        <?php }else{ ?>
                            <?php $i=0; foreach($payment_method as $method => $val){ ?>
                                <hr>
                                <input 
                                    type="radio" 
                                    id="<?php echo $method; ?>" 
                                    name="payment_method" 
                                    value="<?php echo $method; ?>"
                                    <?php echo ($i===0) ? "checked='checked'" : ""; ?>
                                >
                                <label for="<?php echo $method; ?>" class="font-weight-bold"><?php echo $val['title']; ?></label>
                                <div id="desc-<?php echo $method; ?>" class="small">
                                    <?php echo $val['desc']; ?>
                                </div>
                            <?php $i++; } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        

        


        <p class="form-submit">
            <?php //echo $referer; ?>
            <input name="submit" type="submit" id="submit" class="submit button btn btn-primary"
                value="<?php _e('Submit', 'goicc'); ?>" />
            <span class="spinner-border spinner-border-sm" id="form_submit_spinner" role="status" aria-hidden="true" style="display:none;"></span>
            <?php wp_nonce_field( 'checkout-submit' ) ?>
            <input name="action" type="hidden" id="action" value="send_checkout_form" />
            <input name="product_id" type="hidden" id="product_id" value="<?php if(isset($_GET['id'])){echo $_GET['id']; } ?>" />
            <input name="user_id" type="hidden" id="user_id" value="<?php echo $user_id; ?>" />
        </p>

        <div class="alert test" id="infobox" style="display: none">
           
        </div>
    </form>
</div>

<?php get_footer();