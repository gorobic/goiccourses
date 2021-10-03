<?php /* Template Name: Front page */ 

global $user_id;

get_header(); ?>

<!-- Început de Loop. -->
<?php if ( have_posts() ) { 
    while ( have_posts() ) { the_post(); ?>

</div>

<div class="front-jumbo position-relative bg-dark text-light">
    <div class="front-jumbo__bg bg-img bg-cover lazy" data-videobg data-ratio="56.25" data-src="<?php if($post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large')){ echo $post_thumbnail; } ?>">
        <iframe src="https://player.vimeo.com/video/525452066?background=1&autoplay=1&loop=1&autopause=0&byline=0&title=0"
        frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen"></iframe>
    </div>
    <div class="front-jumbo__content h-100 w-100 d-flex align-items-center py-5 py-lg-6 position-relative">
        <div class="w-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8">
                        <div class="text-center">
                            <h1>
                                Cursul tău Academic de Desen propus de Ana Munteanu
                            </h1>
                            <div class="h4 mb-4 mb-lg-5">
                                Un studiu complet al desenului acasă
                            </div>
                            <div class="mb-2">
                                <a href="https://player.vimeo.com/video/525452066?autoplay=1&loop=1&autopause=0&byline=0&title=0" class="btn btn-primary rounded-0 px-3 px-md-4" data-fancybox>
                                    <?php _e('privește 10 minute gratuit', 'goicc'); ?>
                                </a>
                            </div>
                            <div>
                                <a href="https://player.vimeo.com/video/525452066?autoplay=1&loop=1&autopause=0&byline=0&title=0" class="btn text-light rounded-0" data-fancybox>
                                    <?php _e('PRIVEȘTE PROMO', 'goicc'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 mt-lg-6 mb-4 mb-lg-5">
    <div class="row">
        <div class="col-lg-7 pr-lg-5 mb-5">
            <h4 class="mb-4">
                Zeci de ore de video și poze de referință
            </h4>

            <?php 
            $front_images = [
                '/wp-content/uploads/2020/12/2-nature',
                '/wp-content/uploads/2020/12/fantasy-3041033_640',
                '/wp-content/uploads/2020/12/57e4d1474e5ba914f1dc8460962e33791c3ad6e04e5074417d2f7dd49f4ec6_640',
                '/wp-content/uploads/2020/12/54e1d24b4d5aaa14f1dc8460962e33791c3ad6e04e5074417d2e7ed69f49cd_640',
                '/wp-content/uploads/2020/12/2-nature',
                '/wp-content/uploads/2020/12/fantasy-3041033_640',
                '/wp-content/uploads/2020/12/57e4d1474e5ba914f1dc8460962e33791c3ad6e04e5074417d2f7dd49f4ec6_640',
                '/wp-content/uploads/2020/12/54e1d24b4d5aaa14f1dc8460962e33791c3ad6e04e5074417d2e7ed69f49cd_640',
                '/wp-content/uploads/2020/12/2-nature',
                '/wp-content/uploads/2020/12/fantasy-3041033_640',
                '/wp-content/uploads/2020/12/57e4d1474e5ba914f1dc8460962e33791c3ad6e04e5074417d2f7dd49f4ec6_640',
                '/wp-content/uploads/2020/12/54e1d24b4d5aaa14f1dc8460962e33791c3ad6e04e5074417d2e7ed69f49cd_640',

            ];
            ?>
            <div class="row mx-n2">
                <?php foreach($front_images as $front_image){ ?>
                    <div class="col-lg-2 col-sm-3 col-4 px-2 mb-3">
                        <a href="<?php echo $front_image; ?>.jpg" data-fancybox="front-images">
                            <img src="<?php echo $front_image; ?>-150x150.jpg" class="w-100" alt="">
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            <div class="mb-4">
                Cursul conține prima etapă de studiu al desenului. În (aprox) 25 de ore de curs veți învăța noțiuni de perpectivă, constructie, anatomie. 
                <br><br>
                Cursul propune poze de referință după care puteți desena împreună cu profesorul urmărind fiecare etapă. Prima ediție a cursului te învață să construiești să hașurezi și să desenezi un portret uman.
            </div>
            <a href="#start-course" class="btn btn-primary btn-block rounded-0 px-3 px-lg-4">
                Începe cursul
            </a>
        </div>
    </div>
</div>

<div class="container mb-5 mb-lg-6">
    <div class="bg-light px-4 py-5 px-lg-6 border border-gray-200 text-center">
        <h4 class="text-center mb-4 mb-lg-5">
            Te poți consulta cu profesorul!
        </h4>
        
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
        <hr class="w-25">
        A modi, illo minus, praesentium quam culpa fugiat quibusdam libero quis eligendi error aperiam! 
        <hr class="w-25">
        Distinctio quas harum hic dolores porro ut officia?
    </div>
</div>

<div class="container mb-5 mb-lg-6" id="faq">
    <h4 class="text-center mb-4 mb-lg-5">
        F.A.Q.
    </h4>

    <div class="accordion" id="accordion-front-page">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" id="question-heading-1">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#question-collapse-1" aria-expanded="true" aria-controls="question-collapse-1">
                        Cum mă pot înscrie la curs?
                        </button>
                    </h2>
                    </div>

                    <div id="question-collapse-1" class="collapse show" aria-labelledby="question-heading-1" data-parent="#accordion-front-page">
                    <div class="card-body">
                    Pentru a începe cursul apasă oricare din butoanele cu titlul începe cursul. Vei fi redirecționat spre căsuța care te va ajuta să selectezi o opțiune de plată și să creezi un cont personal pe care pe care îl poți accesa de fiecare dată când vrei să privești lecțiile.
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="question-heading-2">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#question-collapse-2" aria-expanded="false" aria-controls="question-collapse-2">
                        Ce este Curs Academic by Ana Munteanu?
                        </button>
                    </h2>
                    </div>

                    <div id="question-collapse-2" class="collapse" aria-labelledby="question-heading-2" data-parent="#accordion-front-page">
                    <div class="card-body">
                    Ana Munteanu propune prima etapă de curs online care presupune studierea temelor conform programului de studii academic în același timp cu profesorul și are la bază principiul academic clasic de studiere a desenului.
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="question-heading-3">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#question-collapse-3" aria-expanded="false" aria-controls="question-collapse-3">
                        Ce este inclus în curs?
                        </button>
                    </h2>
                    </div>

                    <div id="question-collapse-3" class="collapse" aria-labelledby="question-heading-3" data-parent="#accordion-front-page">
                    <div class="card-body">
                    Cursul online de desen te va ajuta să înțelegi de ce materiale ai nevoie, spațiu creativ și cum poți folosi materialele în cadrul temelor pe care le vom realiza împreună. De asemenea cursul îți va pune la dispoziție poze de referință după modelele din curs.
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
            <div class="card">
                    <div class="card-header" id="question-heading-4">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#question-collapse-4" aria-expanded="false" aria-controls="question-collapse-4">
                        Aceste cursuri sunt acreditate?
                        </button>
                    </h2>
                    </div>

                    <div id="question-collapse-4" class="collapse" aria-labelledby="question-heading-4" data-parent="#accordion-front-page">
                    <div class="card-body">
                    Acest curs oferă resurse pentru a cunoaste baza artelor plastice precum este desenul prin metode academice clasice. Acest curs nu oferă acreditare într-o profesie specifică sau o diplomă universitară.
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="question-heading-5">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#question-collapse-5" aria-expanded="false" aria-controls="question-collapse-5">
                        Pot fi descărcate lecțiile video?
                        </button>
                    </h2>
                    </div>

                    <div id="question-collapse-5" class="collapse" aria-labelledby="question-heading-5" data-parent="#accordion-front-page">
                    <div class="card-body">
                    Tot conținutul site-ului este proprietatea Vânzătorului înregistrată în mod corespunzător la Oficiul Român pentru Drepturi de Autor. Dreptul de autor sau orice alte drepturi conexe aparțin Vânzătorului. Este interzisă copierea preluarea, reproducerea, publicarea, transmiterea, vanzarea, distribuția parțială, integrală sau modificarea conținutului. 
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="question-heading-6">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#question-collapse-6" aria-expanded="false" aria-controls="question-collapse-6">
                        Pot împărți cursul cu un prieten?
                        </button>
                    </h2>
                    </div>

                    <div id="question-collapse-6" class="collapse" aria-labelledby="question-heading-6" data-parent="#accordion-front-page">
                    <div class="card-body">
                    Ofertele propuse pe site sunt destinate pentru studiul unui singur cursant.Este interzisă copierea preluarea, reproducerea, publicarea, transmiterea, vanzarea, distribuția parțială, integrală sau modificarea conținutului. Vezi <a href="<?php echo get_privacy_policy_url(); ?>" target="_blank" rel="nofollow">Termeni și Condiții</a>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="question-heading-7">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#question-collapse-7" aria-expanded="false" aria-controls="question-collapse-7">
                        Care este politica de returnare?
                        </button>
                    </h2>
                    </div>

                    <div id="question-collapse-7" class="collapse" aria-labelledby="question-heading-7" data-parent="#accordion-front-page">
                    <div class="card-body">
                    În conformitate cu prevederile legale nu vă puteți retrage achiziția după data acordării dreptului de acces la cursul achiziționat sau după data de început a perioadei de acces la cursul pentru care ați optat. Prin urmare vă puteți retrage oricand din contract înainte de acordare a accesului la serviciile achiziționate. Vezi <a href="<?php echo get_privacy_policy_url(); ?>" target="_blank" rel="nofollow">Termeni și Condiții</a>
                    </div>
                    </div>
                </div>

                <a href="/faq/" class="my-4 d-inline-block"><?php _e('Read more F.A.Q.','goicc'); ?> <span class="small"><span class="goicicons-arrow-light small"></span></span></a>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5 mb-lg-6" id="about">
    <h4 class="text-center mb-4 mb-lg-5">
        <?php _e('About Artist','goicc'); ?>
    </h4>
    <div class="row align-items-center">
        <div class="col-sm-6 col-lg-3 mb-3">
            <div class="text-center text-sm-right text-gray-300 h1 text-uppercase">
                Ana
                <br/>
                Munteanu
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-3">
            <div class="bg-img bg-cover p-ar-1x1 lazy rounded-circle mx-auto ml-sm-0 mx-lg-auto" style="max-width: 180px;" data-src="https://sandart.ro/wp-content/uploads/2018/03/ana-munteanu.jpg"></div>
        </div>
        <div class="col-lg-6 text-center text-lg-left">
            <p>
                Născută la Chișinău, Republica Moldova, este un artist plastic și sand artist.
            </p>
            <p>
                Picturile ei sunt prezente în numeroase colecții particulare din SUA, Italia, Franța, România, Cehia și Moldova.
            </p>
            <a href="/despre-artist/"><?php _e('Read more about artist','goicc'); ?> <span class="small"><span class="goicicons-arrow-light small"></span></span></a>
        </div>
    </div>
</div>

<div class="bg-gray-200 py-5" id="start-course">
    <div class="container">
        <div class="text-center">
            <div class="h2">
                <?php _e('Ready to watch the whole course?','goicc'); ?>
            </div>
            <div class="mb-4">
                <?php _e('Subscribe to this course! Choose a period that is more convenient for you.','goicc'); ?>
            </div>
        </div>
        <?php echo do_shortcode('[course_product course=22]'); ?>
    </div>
</div>

<div class="container">
<? } 
}else{ 
?>

<p>
    <?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?>
</p>

<?php } ?>

<?php get_footer(); ?>