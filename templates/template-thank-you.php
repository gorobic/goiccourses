<?php /* Template Name: Thank You Page */ 

global $user_id;
// @todo: de adaugat 

if ( isset($_GET) && isset($_GET['track']) ){
    // @todo: daca e setat acest parametru, 
    // sa intre in pagina aceasta, sa declanseze javascriptul pentru track, 
    // sa redirectioneze catre aceasta pagina dar faram parametru
    // asta e pentru a evita refresh-ul pe pagina si inregistrarea multipla in analytics
}

get_header(); ?>

<?php if($order_id = check_order($_GET['order_id'])){ ?>

    <?php 
    $payment_status = get_post_meta($order_id, 'goicc_order_status', true);
    switch ($payment_status) {
        case 'completed':
        case 'processing':
            $title = _x( 'Payment was successful', 'Thank You Page', 'goicc' );
            $desc = _x( '', 'Thank You Page', 'goicc' );
            break;
        case 'cancelled':
        case 'refunded':
        case 'failed':
            $title = _x( 'Payment declined', 'Thank You Page', 'goicc' );
            $desc = _x( '', 'Thank You Page', 'goicc' );
            break;
        case 'pending':
        case 'on-hold':
        default:
            $title = _x( 'Payment is being processed', 'Thank You Page', 'goicc' );
            $desc = _x( '', 'Thank You Page', 'goicc' );
    }
    ?>

    <div class="py-5">
        <h1>
            <?php echo $title; ?>
        </h1>
        <?php if($desc){ ?>
            <p>
                <?php echo $desc; ?>
            </p>
        <?php } ?>
        <?php

        $invoice_table = generate_invoice_table($order_id);
        // aici vine detaliile comenzii.

        echo $invoice_table['table'];
        ?>
    </div>

<?php } ?>

<?php get_footer();