<?php get_template_part('templates/emails/email', 'header'); ?>

<p>
Vă mulțumim pentru achiziționarea cursului. 
</p>
<p>
În contul Dvs. de utilizator puteți vedea statusul comenzii sau puteți accesa materialele de curs.
</p>
<p>
<a href="<?php echo $args['account_page']?>">Accesează contul de utilizator</a>
</p>

<?php get_template_part('templates/emails/email', 'footer');