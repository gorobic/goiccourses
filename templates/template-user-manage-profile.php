<?php /* Template Name: User Manage Profile */ 

global $user_id;

/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {
    /* Get user info. */
    $update_user_result = validate_and_save_user_fields($_POST, $user_id, $current_user->data->user_pass);

}

get_header();

$current_tab = user_account_current_tab();
?>
<?php if ( !is_user_logged_in() ){ ?>

    <div class="position-relative">
        <?php get_template_part( 'template-parts/user/user-alert', 'authentication' ); ?>
    </div>

<?php }else{ ?>

<h1>
    <?php echo $user_account_tabs[$current_tab]; ?>
</h1>

<hr>

<?php the_content(); ?>

<div class="row">
    <div class="col-lg-9 col-md-8 mb-3">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div id="post-<?php the_ID(); ?>">
            <div class="entry-content entry">

                <?php if ( $update_user_result && count($update_user_result['error']) > 0 ){ ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo implode("<br />", $update_user_result['error']); ?>
                </div>
                <?php }elseif($update_user_result['success']){ ?>
                <div class="alert alert-success" role="alert">
                    <?php _e('The changes have been applied.','goicc'); ?>
                </div>
                <?php } ?>

                <?php include_once wp_normalize_path( get_template_directory() . '/template-parts/user/user-tab-'. $current_tab .'.php' ); ?>

            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <p class="no-data">
            <?php _e('Sorry, no page matched your criteria.', 'goicc'); ?>
        </p><!-- .no-data -->
        <?php endif; ?>
    </div>
    <div class="col-lg-3 col-md-4 mb-3 order-md-first">
        <?php include_once wp_normalize_path( get_template_directory() . '/template-parts/user/user-nav.php' ); ?>
    </div>
</div>
<?php } ?>
<?php get_footer();