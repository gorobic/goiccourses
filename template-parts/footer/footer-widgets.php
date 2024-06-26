<?php if (is_active_sidebar('footer-widgets-1') || is_active_sidebar('footer-widgets-2') || is_active_sidebar('footer-widgets-3') || is_active_sidebar('footer-widgets-4')) { ?>
    <div class="bg-dark text-light footer-widgets overflow-hidden">
        <div class="container-xl mt-5 mb-4">
            <aside class="widget-area row" role="complementary" aria-label="<?php esc_attr_e('Footer', 'goicc'); ?>">
                <div class="col-sm-6 col-lg-3">
                    <?php if (is_active_sidebar('footer-widgets-1')) {
                        dynamic_sidebar('footer-widgets-1');
                    } ?>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <?php if (is_active_sidebar('footer-widgets-2')) {
                        dynamic_sidebar('footer-widgets-2');
                    } ?>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <?php if (is_active_sidebar('footer-widgets-3')) {
                        dynamic_sidebar('footer-widgets-3');
                    } ?>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <?php if (is_active_sidebar('footer-widgets-4')) {
                        dynamic_sidebar('footer-widgets-4');
                    } ?>
                </div>
            </aside><!-- .widget-area -->
        </div>
    </div>

<?php } ?>