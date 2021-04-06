<?php get_header(); ?>

<!-- Început de Loop. -->
<?php if ( have_posts() ) { 
    while ( have_posts() ) { the_post();

        get_template_part('template-parts/content/content');

    } 
}else{ 
?>

<p>
    <?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?>
</p>

<?php } ?>

<?php get_footer(); ?>