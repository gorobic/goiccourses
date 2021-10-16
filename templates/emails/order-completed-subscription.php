<?php get_template_part('templates/emails/email', 'header'); ?>

<p>
Ați primit acces la cursul <strong><?php echo get_the_title($args['product_id']); ?></strong>
</p>
<p>
Accesați link-ul de mai jos pentru a începe cursul.
</p>
<p>
<a href="<?php echo get_permalink($args['product_id']); ?>">Vezi cursul</a>
</p>
<p>
    <small>
        Notă: asigurați-vă că sunteți autentificat în contul de utilizator pentru a avea acces la materialele de curs.
    </small>
</p>

<?php get_template_part('templates/emails/email', 'footer');