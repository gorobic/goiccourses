<?php 
function get_ty_page_url($order_id_full){
    global $user_id, $thankyou_page_permalink;

    $destination = $thankyou_page_permalink.'?order_id='.$order_id_full;
    $destination .= '&track=true';

    if($order_id = check_order($order_id_full)){
        $payment_status = get_post_meta($order_id, 'goicc_payment_status', true);
        $destination .= '&payment_status='.$payment_status;
    }

    if(user_can( $user_id, 'administrator' )){
        $destination .= '&sandbox=true';
    }

    return $destination;
}

function generate_invoice($order_id, $order_meta){
    if(!$order_id) return false;
    $order_data = get_post($order_id, 'ARRAY_A');

    $is_company = $order_meta['is_company'][0];

    $invoice = [
        'order' => [
            'order_status' => $order_meta['goicc_order_status'][0],
            'payment_status' => $order_meta['goicc_payment_status'][0],
            'payment_method' => $order_meta['goicc_payment_method'][0],
            'extra_details' => do_action('goicc_invoice_product_extra_details'),
        ],
        'seller' => [
            'company_name' => [
                'l' => __('Unitatea', 'goicc'),
                'v' => 'SC ANA MUNTEANU ART SRL',
            ],
            'vat_code' => [
                'l' => __('VAT Code','goicc'),
                'v' => '36653965 ',
            ],
            'nr_reg_com' => [
                'l' => __('Nr. Ord. Reg. Com.', 'goicc'),
                'v' => 'J40/13823/20.10.2016',
            ],
            'headquarters' => [
                'l' => __('Sediu social', 'goicc'),
                'v' => 'București, Sector 3, str. Liviu Rebreanu, nr. 46-58, camera nr. 3, bloc Tronson V, et. 4, Ap. 42',
            ],
            'iban' => [
                'l' => __('IBAN', 'goicc'),
                'v' => 'RO44INGB0000999906349739',
            ],
            'bank_name' => [
                'l' => __('Bank name','goicc'),
                'v' => 'INGB CENTRALA',
            ],
        ],
        'buyer' => [
            'name' => [
                'l' => __('Buyer', 'goicc'),
                'v' => $is_company ? $order_meta['company_name'][0] : $order_meta['goicc_order_first_name'][0] . ' ' . $order_meta['goicc_order_last_name'][0],
            ],
            // '' => [
            //     'l' => __('', 'goicc'),
            //     'v' => $order_meta[''][0],
            // ],
        ],
        'header' => [
            'invoice_label' => __('Factura Proformă nr.', 'goicc'),
            'invoice_number' => $order_id,
            'invoice_series' => '',
            'date_label' => __('Data', 'goicc'),
            'date' => date('d.m.Y'),
            'date_unformatted' => date('Ymd')
        ],
        'table' => [
            'labels' => [
                __('Nr.crt', 'goicc'),
                __('Denumirea produselor', 'goicc'),
                __('UM', 'goicc'),
                __('Cantitatea', 'goicc'),
                __('Prețul unitar<br>-RON-', 'goicc'),
                __('Valoare<br>-RON-', 'goicc'),
            ],
            'columns_order' => [ 0, 1, 2, 3, 4, '5(3x4)' ],
            'unit_label' => __('buc.', 'goicc'),
        ],
        'products' => [
            
        ],
        'table_footer' => [
            'issuer_label' => __('Document emis de:', 'goicc'),
            'issuer' => '', // Nume Prenume emitent
            'issuer_id' => '', // CNP emitent
            'sign_label' => __('Semnătura și ștampila furnizorului', 'goicc'),
            'total_label' => __('Total', 'goicc'),
            'total_payment_label' => __('Total de plată', 'goicc'),
            'total_payment' => number_format($order_meta['goicc_total_price'][0], 2)
        ],
        'order_data' => $order_data,
        'order_meta' => $order_meta,
        'is_company' => $is_company
    ];
    
    for($i = 0; isset($order_meta['goicc_order_products_'.$i.'_goicc_order_products_title']); $i++){
        $invoice['products'][] = [
            'title' => $order_meta['goicc_order_products_'.$i.'_goicc_order_products_title'][0],
            'price' => $order_meta['goicc_order_products_'.$i.'_goicc_order_products_price'][0],
        ];
    }

    return apply_filters( 'goicc_generate_invoice', $invoice );
    // return $invoice;
}

function generate_invoice_table($order_id, $fiscal = false){
    $order_meta = get_post_meta($order_id);
    $invoice_data = generate_invoice($order_id, $order_meta);
    $user_extra_fields_billing = goicc_get_user_extra_fields()['billing'];
    ob_start(); 
    ?>
        <div>
            <div id="invoicePrintWrap">
                <div id="invoiceWrap">
                    <style>
                        @media print{
                            #invoiceWrap *{
                                box-sizing: border-box;
                            }

                            #invoiceWrap .row{
                                display: flex;
                                width: 100%;
                            }

                            #invoiceWrap .row > *{
                                width: 50%;
                                padding-right: 20px;
                                margin-bottom: 20px;
                            }

                            #invoiceWrap table{
                                width: 100%;
                                border-collapse: collapse;
                                border-spacing: 0;
                            }

                            #invoiceWrap .table-before{
                                margin-bottom: 20px;
                                text-align: center;
                            }

                            #invoiceWrap table th,
                            #invoiceWrap table td{
                                vertical-align: top;
                                border: 1px solid #000;
                                padding: 10px;
                            }

                            #invoiceWrap table thead th,
                            #invoiceWrap table thead td{
                                text-align: center;
                                vertical-align: middle;
                            }
                        }
                    </style>
                    <div class="row">
                        <div class="company mb-4 col-sm-6">
                            <?php foreach($invoice_data['seller'] as $seller){ ?>
                                <div>
                                    <?php echo $seller['l'] . ': ' . $seller['v']; ?>
                                </div>
                            <?php } unset($seller); ?>
                        </div>
                        <div class="customer mb-4 col-sm-6">
                            <div>
                                <?php echo $invoice_data['buyer']['name']['l'] . ': ' . $invoice_data['buyer']['name']['v']; ?>
                            </div>
                            <div>
                                <?php echo $user_extra_fields_billing['general']['address']['title'] . ': ' . $invoice_data['order_meta']['address'][0]; ?>
                            </div>
                            <div>
                                <?php echo $user_extra_fields_billing['general']['city']['title'] . ': ' . $invoice_data['order_meta']['city'][0]; ?>
                            </div>
                            <div>
                                <?php echo $user_extra_fields_billing['general']['state']['title'] . ': ' . $invoice_data['order_meta']['state'][0]; ?>
                            </div>
                            <div>
                                <?php echo $user_extra_fields_billing['general']['country']['title'] . ': ' . $invoice_data['order_meta']['country'][0]; ?>
                            </div>
                            <?php if($invoice_data['is_company']){ ?>
                                <div>
                                    <?php echo $user_extra_fields_billing['company']['nr_reg_com']['title'] . ': ' . $invoice_data['order_meta']['nr_reg_com'][0]; ?>
                                </div>
                                <div>
                                    <?php echo $user_extra_fields_billing['company']['vat_code']['title'] . ': ' . $invoice_data['order_meta']['vat_code'][0]; ?>
                                </div>
                                <div>
                                    <?php echo $user_extra_fields_billing['company']['iban']['title'] . ': ' . $invoice_data['order_meta']['iban'][0]; ?>
                                </div>
                                <div>
                                    <?php echo $user_extra_fields_billing['company']['bank_name']['title'] . ': ' . $invoice_data['order_meta']['bank_name'][0]; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="table-before text-center">
                        <h3><?php echo $invoice_data['header']['invoice_label'] . ' ' . $invoice_data['header']['invoice_number'] . ' ' . $invoice_data['header']['invoice_series']; ?></h3>
                        <p><?php echo $invoice_data['header']['date_label'] . ' ' . $invoice_data['header']['date']; ?></p>
                    </div>
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <?php foreach($invoice_data['table']['labels'] as $col){ ?>
                                            <td>
                                                <?php echo $col; ?>
                                            </td>
                                        <?php } unset($col); ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php foreach($invoice_data['table']['columns_order'] as $col){ ?>
                                            <td>
                                                <?php echo $col; ?>
                                            </td>
                                        <?php } unset($col); ?>
                                    </tr>
                                    <?php $i = 1; foreach($invoice_data['products'] as $product){ ?>
                                        <tr>
                                            <td>
                                                <?php echo $i; ?>
                                            </td>
                                            <td>
                                                <?php echo $product['title']; ?>
                                            </td>
                                            <td>
                                                <?php echo $invoice_data['table']['unit_label']; ?>
                                            </td>
                                            <td>
                                                1
                                            </td>
                                            <td>
                                                <?php echo $product['price']; ?>
                                            </td>
                                            <td>
                                                <?php echo $product['price']; ?>
                                            </td>
                                        </tr>
                                    <?php $i++; } unset($i); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td rowspan="2"></td>
                                        <td rowspan="2">
                                            <div><?php echo $invoice_data['table_footer']['issuer_label']; ?></div>
                                            <div><?php echo $invoice_data['table_footer']['issuer']; ?></div>
                                            <div><?php echo $invoice_data['table_footer']['issuer_id']; ?></div>
                                        </td>
                                        <td rowspan="2" colspan="2">
                                            <?php echo $invoice_data['table_footer']['sign_label']; ?>
                                        </td>
                                        <td>
                                            <?php echo $invoice_data['table_footer']['total_label']; ?>
                                        </td>
                                        <td>
                                            <?php echo $invoice_data['table_footer']['total_payment']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $invoice_data['table_footer']['total_payment_label']; ?>
                                        </td>
                                        <td>
                                            <span id="totalPayment">
                                                <?php echo $invoice_data['table_footer']['total_payment']; ?>
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hide-on-print my-3">
            <button class="btn btn-sm btn-primary mr-2" onclick="printPartOfPage('invoicePrintWrap')"><?php _e('Print','goicc'); ?></button>
            <?php do_action('goicc_order_details_buttons', $order_id, $order_meta); ?>
            </div>
        </div>
    <?php
    $table = ob_get_clean();
    return [
        'table' => $table,
        'data' => $invoice_data,
    ];
}