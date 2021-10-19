<?php get_template_part('templates/emails/email', 'header'); ?>
<h3 style="margin-bottom: 0;">
    Salut!
</h3>
<p style="margin-top: 0;">
    Se apropie de sfârșit perioada de înscriere la cursul "<strong><?php echo $args['product_title']; ?></strong>". 
</p>
<p>
    În contul de utilizator ți-a fost generată o factură proformă. Dacă mai ai nevoie de timp pentru a învăța, poți prelungi accesul la curs achitând factura:
</p>
<p>
<a href="<?php echo $args['new_order_url']?>">Accesează factura proformă</a>
</p>
<p>
<?php // @todo: de șters informația despre etapa a doua după ce pe site apare această etapă ?>
Dacă consideri că ai asimilat informația nu uita să exersezi de sine stătător pînă revenim cu etapa a II-a Cursului Academic de Desen. Să știi că fără exersări nu există drum spre succes!
</p>
<p>
Îți mulțumim!
</p>

<?php get_template_part('templates/emails/email', 'footer');