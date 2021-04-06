<?php
global $user_id, $registration_url, $login_url;
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo esc_url(get_bloginfo('url')); ?>">
            <?php $custom_logo_id = esc_attr(get_theme_mod( 'custom_logo' ));
            $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            if(has_custom_logo()){ ?>
            <img src="<?php echo esc_url( $logo[0] ); ?>" class="d-inline-block custom-logo"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <?php }else{ ?>
            <?php echo esc_attr(get_bloginfo('name')); ?>
            <?php } ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
                        'container'       => 'ul',
                        //'container_class' => 'collapse navbar-collapse',
                        'menu_class'      => 'navbar-nav mr-auto',
                        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'          => new WP_Bootstrap_Navwalker(),
                    )
                );
            } ?>

            <ul class="nav navbar-nav ml-auto">
                <?php if(is_user_logged_in()){ ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbar-img" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php _e('Hello','goicc'); ?>, 
                            <?php 
                                if($user_display_name = get_the_author_meta( 'first_name', $user_id ));
                                elseif($user_display_name = get_the_author_meta( 'user_login', $user_id )){
                                    if(is_email($user_display_name)){
                                        $user_display_name = explode('@', $user_display_name)[0];
                                    }
                                }
                                else $user_display_name = __('User', 'goicc');

                                echo $user_display_name;
                            ?>

                            <img src="<?php echo get_avatar_url($user_id, array('size' => 36)); ?>" class="user-avatar rounded-circle border border-dark ml-1" alt="">
                        </a>
                        <div class="dropdown-menu dropdown-dark dropdown-menu-right rounded-0">
                            <?php $user_account_tabs = goicc_get_user_account_tabs(); if($user_account_tabs && is_array($user_account_tabs)){ 
                                $account_page = accout_page_url();
                                $current_tab = user_account_current_tab();
                                foreach($user_account_tabs as $key => $tab){ ?>
                                    <a href="<?php echo $account_page . '?tab=' . $key; ?>"
                                        class="dropdown-item <?php if($current_tab === $key){echo 'active';} ?>">
                                        <?php echo $tab; ?>
                                    </a>
                                    <?php 
                                    unset($tab); 
                                } 
                            } ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo wp_logout_url(); ?>"><?php _e('Log out','goicc'); ?></a>
                        </div>
                    </li>
                <?php }else{ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $login_url; ?>"><?php _e('Sign In','goicc'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $registration_url; ?>"><?php _e('Sign Up','goicc'); ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>


        
    </div>
</nav>