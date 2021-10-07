        </div>

        
        <footer>
        
            <?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>

            <?php get_template_part( 'template-parts/footer/site', 'info' ); ?>

        </footer>
    </div>
    <?php wp_footer(); ?>


    <?php 
        $args = array(
            'nopaging' => true,
            'suppress_filters' => false,
            'post_status' => 'publish',
            'post_type' => array( 'goicc_order' ),
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'goicc_order_status',
                    'value'   => 'completed',
                    'compare' => 'IN',
                ),
                array(
                    'key'     => 'goicc_subscription_start_date',
                    'value'   => date('Ymd'),
                    //'value'   => //date('Ymd', strtotime('+1 day')),
                    'compare' => '<=',
                ),
                array(
                    'key'     => 'goicc_subscription_end_date',
                    'value'   => date('Ymd', strtotime('+5 days')),
                    'compare' => '=',
                ),
            ),
        );
        $posts = get_posts($args);
        if($posts){
            $payment_method = goicc_get_payment_method();
            foreach($posts as $post){
                $post = (array) $post;
                
                $old_order_meta = get_post_meta($post['ID']);
                $product_id = $old_order_meta['goicc_order_product_id'][0];

                // Do not create order if the product on which it is based no longer exists on the site
                if(get_post_status($product_id) !== 'publish') continue;

                $subscription_start_date = $old_order_meta['goicc_subscription_end_date'][0];
                
                $order_data = [];
                $user_id = $post['post_author'];
                $order_data['user_id'] = $user_id;
                $order_data['first_name'] = get_the_author_meta( 'first_name', $user_id );
                $order_data['last_name'] = get_the_author_meta( 'last_name', $user_id );
                $order_data['user_email'] = get_the_author_meta( 'user_email', $user_id );
                $order_data['is_company'] = get_the_author_meta( 'is_company', $user_id );
                $order_data['product_id'] = $product_id;

                
                $old_order_payment_method = $old_order_meta['goicc_payment_method'][0];
                if($old_order_payment_method && in_array($old_order_payment_method, array_keys($payment_method))){
                    $order_data['payment_method'] = $old_order_payment_method;
                }else{
                    $order_data['payment_method'] = array_key_first($payment_method);
                }

                $user_extra_fields = goicc_get_user_extra_fields();
                foreach($user_extra_fields['billing'] as $person_type_key => $person_type){
                    foreach($person_type as $field => $val){
                        $order_data[$field] = get_the_author_meta( $field, $user_id );
                    }
                }

                $new_order = create_order($order_data, $user_id);

                if($new_order){
                    // var_dump($order_data);
                    // var_dump($new_order);

                    $account_page = accout_page_url();
                    $new_order_url = $account_page . '?tab=billing-history&order_id=' . $new_order['order_id'] . '-' . $new_order['order_unique_id'];
                    $product_title = get_the_title($order_data['product_id']);
                    ob_start();
                    get_template_part('templates/emails/customer', 'subscription-update', array('new_order_url' => $new_order_url, 'order_data' => $order_data, 'product_title' => $product_title));
                    $email_body = ob_get_clean();
                    // @todo: dacă site-ul va fi bilingv, de memorat în contul utilizatorului preferința de limbă și de afișat subiectul respectiv limbii
                    $subject = 'A fost emisă o nouă factură proformă';
                    $headers = array(
                        'Content-Type: text/html; charset=UTF-8',
                        'Reply-To: ' . get_bloginfo('admin_email')
                    );

                    wp_mail(
                        $order_data['user_email'],
                        $subject,
                        $email_body,
                        $headers
                    );

                    // @todo: de trimis email cand se creaza noua factura if create_order returneaza id-ul orderului.
                    // in email trimit link catre cabinetul personal direct la order sa il achite
                }else{
                    // @todo: de trimis email sau creat log cu eroarea la creare postare
                }



            }
        }
    ?>

    </body>

    </html>