<?php get_header(); ?>

<!-- Început de Loop. -->
<?php if ( have_posts() ) { 
    while ( have_posts() ) { the_post(); ?>
<article <?php post_class('mb-4'); ?> id="page-<?php the_ID(); ?>">
    <header class="entry-header border-bottom pb-4 my-4">
        <h1 class="title m-0">
            <?php the_title(); ?>
        </h1>
    </header>

    <div class="entry mb-4">
        <?php the_content(); ?>
    </div>
</article>
<? } 
}else{ 
?>

<p>
    <?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?>
</p>

<?php } ?>

<?php get_footer(); ?>