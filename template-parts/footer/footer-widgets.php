<?php if ( is_active_sidebar( 'footer-widgets-1' ) || is_active_sidebar( 'footer-widgets-2' ) || is_active_sidebar( 'footer-widgets-3' ) || is_active_sidebar( 'footer-widgets-4' ) ){ ?>
<div class="bg-dark text-light footer-widgets overflow-hidden">
    <div class="container mt-5 mb-4">
        <aside class="widget-area row" role="complementary"
            aria-label="<?php esc_attr_e( 'Footer', 'text_domain' ); ?>">
            <?php if ( is_active_sidebar( 'footer-widgets-1' )){ ?>
                <div class="col-sm-6 col-lg-3">
                    <?php dynamic_sidebar( 'footer-widgets-1' ); ?>
                </div>
            <?php } ?>
            <?php if ( is_active_sidebar( 'footer-widgets-2' )){ ?>
                <div class="col-sm-6 col-lg-3">
                    <?php dynamic_sidebar( 'footer-widgets-2' ); ?>
                </div>
            <?php } ?>
            <?php if ( is_active_sidebar( 'footer-widgets-3' )){ ?>
                <div class="col-sm-6 col-lg-3">
                    <?php dynamic_sidebar( 'footer-widgets-3' ); ?>
                </div>
            <?php } ?>
            <?php if ( is_active_sidebar( 'footer-widgets-4' )){ ?>
                <div class="col-sm-6 col-lg-3">
                    <?php dynamic_sidebar( 'footer-widgets-4' ); ?>
                </div>
            <?php } ?>
        </aside><!-- .widget-area -->
    </div>
</div>

<?php } ?>