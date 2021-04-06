<article <?php post_class('mb-4'); ?> id="post-<?php the_ID(); ?>">
    <header class="entry-header">
        <h2 class="title">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php the_title(); ?>
            </a>
        </h2>
    </header>
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
</article>