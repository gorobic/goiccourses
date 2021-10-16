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
Ați primit acces la cursul "<strong><?php echo get_the_title($course_id); ?></strong>"
</p>
<p>
Accesați link-ul de mai jos pentru a începe cursul.
</p>
<p>
<a href="<?php echo get_permalink($course_id); ?>">Vezi cursul</a>
</p>

<?php get_template_part('templates/emails/email', 'footer');