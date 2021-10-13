<div class="footer-info pt-3 bg-dark text-light border-top border-gray-800">
    <div class="container">
        <div class="row align-items-center">
            <div class="copyright col-lg-6 text-center text-lg-left mb-3">
                <?php echo date('Y'); ?> © <?php echo get_bloginfo('name'); ?>. <?php _e('All rights reserved', 'goicc'); ?>.
            </div>
            <div class="footer-logos col-lg-6 text-center text-lg-right mb-3">
                <?php echo file_get_contents(get_stylesheet_directory_uri()."/assets/images/mastercard-logo.svg"); ?>
                <?php echo file_get_contents(get_stylesheet_directory_uri()."/assets/images/visa-logo.svg"); ?>
                <?php echo file_get_contents(get_stylesheet_directory_uri()."/assets/images/netopia-payments-logo.svg"); ?>
            </div>
        </div>
    </div>
</div>