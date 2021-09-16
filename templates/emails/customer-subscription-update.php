<?php get_template_part('templates/emails/email', 'header'); ?>

<p>
În scurt timp expiră accesul la produsul "<strong><?php echo $args['product_title']; ?></strong>". 
</p>
<p>
În contul Dvs. de utilizator a fost generată factură proformă. Vă rugăm să achitați factura pentru a prelungi accesul la curs.
</p>
<p>
<a href="<?php echo $args['new_order_url']?>">Accesează factura proformă</a>
</p>

<?php get_template_part('templates/emails/email', 'footer');