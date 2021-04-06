<?php get_header(); ?>

<header class="entry-header">
    <?php if ( have_posts() ){ ?>
    <h1 class="title">
        <?php printf( __( 'Search Results for: %s', 'text_domain' ), '<span>' . get_search_query() . '</span>' ); ?>
    </h1>
    <?php }else{ ?>
    <h1 class="title"><?php _e( 'Nothing Found', 'text_domain' ); ?></h1>
    <?php } ?>
</header>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php if (have_posts()) { ?>

        <div class="mb-3">
            <?php get_search_form(); ?>
        </div>

        <div class="posts-wrap row">
            <?php while (have_posts()){ the_post();
                echo "<div class='col-12 mb-3 col-sm-6 col-md-4'>";
                get_template_part('template-parts/my_movies/content', 'excerpt');
                echo "</div>";
            }
                
            if ($wp_query->max_num_pages > 1) {?>
            <div class="alignleft">
                <?php next_posts_link( __( '<span>&laquo;</span> Older posts', 'text_domain' ) );?>
            </div>
            <div class="alignright">
                <?php previous_posts_link( __( 'Newer posts <span>&raquo;</span>', 'text_domain' ) );?>
            </div>
            <?php } ?>
        </div>
        <?php } else { ?>

        <p>
            <?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'text_domain'); ?>
        </p>
        <?php get_search_form(); ?>

        <?php } ?>
    </main>
</div>

<?php get_footer(); ?>