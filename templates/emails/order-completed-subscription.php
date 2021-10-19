<?php get_template_part('templates/emails/email', 'header'); 

$connected_courses = get_posts( array(
    'connected_type' => 'posts_to_product',
    'connected_items' => $args['product_id'],
    'nopaging' => true,
    'suppress_filters' => false
) );
if($connected_courses){
    $connected_course = $connected_courses[0];
    $course_id = $connected_course->ID;
}
?>

<p>
    Ai primit acces la cursul "<strong><?php echo get_the_title($course_id); ?></strong>" de pe site-ul www.cursacademic.ro
</p>
<p>
    Urmează link-ul de mai jos pentru a accesa materialele de curs și pentru a începe procesul de învățare:
</p>
<p>
    <a href="<?php echo get_permalink($course_id); ?>">Vezi cursul</a>
</p>
<p>
    De acum încolo atenția și străduința te vor ajuta să studiezi arta Desenului Academic!
</p>

<?php get_template_part('templates/emails/email', 'footer');