<?php get_template_part('templates/emails/email', 'header'); ?>
<?php 
$payment_method = get_post_meta($args['order_id'], 'goicc_payment_method');
?>
<p>
    Îți mulțumim pentru înscrierea la curs! Felicitări, ai făcut primul pas!
</p>
<?php if($payment_method == 'bank_transfer'){ ?>
    <p>
        Odată ce vom putea confirma achitarea, vom activa accesul la curs. De obicei durează 2-3 zile lucrătoare. Dacă dorești să grăbești acest proces ne poți transmite o dovadă de plată pe adresa <a href="mailto:artist@cursacademic.ro">artist@cursacademic.ro</a> sau ca reply la acest email.
    </p>
<?php }else{ ?>
    <p>
        În scurt timp vei primi un email de acces la curs, după ce confirmăm efectuarea plății.
    </p>
<?php } ?>
<p>
    Accesează contul de utilizator pentru a vedea istoricul și statusul comenzilor:
</p>
<p>
<a href="<?php echo $args['account_page']?>">Spre contul de utilizator</a>
</p>

<?php get_template_part('templates/emails/email', 'footer');