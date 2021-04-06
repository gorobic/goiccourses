<?php 
$user_account_tabs = goicc_get_user_account_tabs();
if($user_account_tabs && is_array($user_account_tabs)){ 
    $account_page = accout_page_url();
?>
<div class="btn-group-vertical w-100">
    <?php foreach($user_account_tabs as $key => $tab){ ?>
    <a href="<?php echo $account_page . '?tab=' . $key; ?>"
        class="btn btn-outline-dark rounded-0 text-left <?php if($current_tab === $key){echo 'active';} ?>">
        <?php echo $tab; ?>
    </a>
    <?php unset($tab); } ?>
    <a href="<?php echo wp_logout_url(); ?>"
        class="btn btn-outline-dark rounded-0 text-left "><?php _e('Log out','goicc'); ?></a>
</div>
<?php } ?>