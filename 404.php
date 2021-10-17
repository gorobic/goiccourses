<?php get_header(); ?>

<!-- Început de Loop. -->
<article <?php post_class('mb-4'); ?> id="page-<?php the_ID(); ?>">
    <header class="entry-header border-bottom pb-4 my-4">
        <h1 class="title m-0">
            404. <?php _e('Page not found', 'goicc'); ?>
        </h1>
    </header>

    <div class="entry mb-4">
        <p>
            <?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for.', 'goicc'); ?>
        </p>
        <p>
            <a href="/" class="btn btn-outline-primary rounded-0"><?php _e('Go home', 'goicc'); ?></a>
        </p>
    </div>
</article>

<?php get_footer(); ?>