<article <?php post_class('mb-4'); ?> id="post-<?php the_ID(); ?>">
    <header class="entry-header">
        <h1 class="title">
            <?php the_title(); ?>
        </h1>
    </header>

    <!-- Afișăm data (November 16th, 2009 format) -->
    <!-- și link spre alte postări ale autorului. -->

    <small><?php the_time('F jS, Y'); ?> by <?php the_author_posts_link(); ?></small>



    <div class="entry">
        <?php the_content(); ?>
    </div>

    <!-- Afișăm categoriile din care face parte postarea, separate prin virgulă. -->

    <p class="postmetadata"><?php _e( 'Posted in' ); ?> <?php the_category( ', ' ); ?></p>
</article>