<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form form-inline my-2 my-lg-0"
    action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="<?php echo $unique_id; ?>">
        <span class="sr-only"><?php echo _x( 'Search for:', 'label', 'text_domain' ); ?></span>
    </label>
    <input type="search" id="<?php echo $unique_id; ?>" class="search-field form-control mr-sm-2"
        placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'text_domain' ); ?>"
        value="<?php echo get_search_query(); ?>" name="s" />

    <input type="hidden" name="post_type" value="my_movies" />
    <button type="submit" class="search-submit btn btn-outline-success my-2 my-sm-0">
        <span class="sr-only"><?php echo _x( 'Search', 'submit button', 'text_domain' ); ?></span>
        <span><?php echo _x( 'Search', 'submit button', 'text_domain' ); ?></span>
    </button>
</form>