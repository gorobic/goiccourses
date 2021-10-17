<?php get_header(); ?>

<header class="entry-header">
    <h1 class="title"><?php single_post_title(); ?></h1>
</header>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php if (have_posts()) { ?>
        <div class="posts-wrap">
            <?php while (have_posts()){ the_post();
                    
                get_template_part('template-parts/content/content', 'excerpt');
                
            }
                
            echo paginate_links(); ?>
        </div>
        <?php } else { ?>

        <p>
            <?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'goicc'); ?>
        </p>
        <?php get_search_form(); ?>

        <?php } ?>
    </main>
</div>

<?php get_footer(); ?>