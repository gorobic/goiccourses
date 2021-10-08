<?php 
$connected_courses = get_posts( array(
    'connected_type' => 'courses_to_videolessons',
    'connected_items' => get_queried_object(),
    'nopaging' => true,
    'suppress_filters' => false
) );
if($connected_courses){
    $connected_course = $connected_courses[0];
    $course_id = $connected_course->ID;
}

global $user_id;

$active_subscription = check_active_subscription_to_course($user_id, get_the_ID());
if(!$active_subscription){
    header('Location: '.home_url());
    die();
}
?>
<?php get_header(); ?>

<?php if ( have_posts() ) { 
    while ( have_posts() ) { the_post();

        // Vide lessons must be assigned to course. If not, stop rendering this page.
        if(!$course_id){

            // @todo: aici ar trebui să vină un mesaj că acest capitol nu poate fi accesat. DELOC

        }else{ 

            $videolessons_videos = get_field('goicc_videolessons_videos');
            $duration = get_field('goicc_videolessons_duration');
            
            $back_to_course = __('Back to Course','goicc');

            $related_videolessons = get_posts( array(
                'connected_type' => 'courses_to_videolessons',
                'connected_items' => $course_id,
                'nopaging' => true,
                'suppress_filters' => false,
                'fields' => 'ids'
            ) );

            $current_index = array_search(get_the_ID(), $related_videolessons);

            $videos = get_field('goicc_videolessons_videos');
            $references = get_field('goicc_videolessons_references');
            $homework = get_field('goicc_videolessons_homework');
            
            ?>
            
            </div>

            <div class="bg-gray-800 text-light border-top border-gray-900">
                <div class="container">
                    <a href="<?php echo esc_url( get_permalink($course_id) ); ?>" class="text-gray-600 small font-weight-light" title="<?php echo $back_to_course; ?>">
                        « <?php echo $back_to_course; ?>
                    </a>
                    <div>
                    <h1 class="h5 font-weight-light d-inline-block">
                        <?php the_title(); ?>
                    </h1>
                    <div id="video-title" class="d-inline-block h5 text-gray-600"></div>
                    </div>
                    <div id="video-box" class="mx-nrow mx-md-0">
                        <div class="bg-img bg-cover lazy" data-src="<?php if($post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large')){ echo $post_thumbnail; } ?>">
                            <div class="row no-gutters">
                                <div class="col-md-8 col-lg-6 col-xl-5">
                                    <div class="py-5 py-md-4 px-4 my-md-6 videolessons-play-course-box videolessons-play-first-video">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <span class="font-weight-light h4">
                                                    <?php _e('Play first video lesson','goicc'); ?>
                                                </span>
                                            </div>
                                            <div class="col-auto mx-auto mr-md-0 pl-3">
                                                <span class="display-3">
                                                    <span class="goicicons-play-square"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                                        
            <article <?php post_class('py-5'); ?> id="post-<?php the_ID(); ?>">
                
                <div class="row">
                    
                    <div class="col-md-8 col-xl-9">

                        <div class="chapter-tabs">
                            <ul class="nav nav-tabs" id="chapter-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">
                                        <?php _e('Details','goicc'); ?>
                                    </a>
                                </li>
                                <?php if($references){ ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="references-tab" data-toggle="tab" href="#references" role="tab" aria-controls="references" aria-selected="false">
                                            <?php _e('References','goicc'); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php /*if($homework){ ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="homework-tab" data-toggle="tab" href="#homework" role="tab" aria-controls="homework" aria-selected="false">
                                            <?php _e('Homework','goicc'); ?>
                                        </a>
                                    </li>
                                <?php }*/ ?>
                            </ul>
                            <div class="tab-content pt-3" id="chapter-tabs-content">
                                <div id="details" class="tab-pane fade show active" role="tabpanel" aria-labelledby="details-tab">
                                    <div class="chapter-meta">
                                        <?php if($duration){ ?>
                                            <span class="font-weight-light mr-2">
                                                <?php echo seconds_to_time($duration, true); ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                    
                                    <?php //if( '' !== get_post()->post_content ) { ?>

                                        <div class="entry mt-2">
                                            <?php /* <div class="h4">
                                                <?php _e('Chapter details','goicc'); ?>
                                            </div> */ ?>

                                            <?php 
                                            $course_post = get_post($course_id);
                                            $course_content = $course_post->post_content;
                                            if($course_content){
                                                $course_content = apply_filters('the_content', $course_content);
                                                $course_content = str_replace(']]>', ']]&gt;', $course_content);
                                                ?>
                                                <div class="h4">
                                                    <?php _e('Course description','goicc'); ?>
                                                </div> 
                                                <?php
                                                echo $course_content;
                                            }
                                            // the_content(); ?>
                                        </div>

                                    <?php //} ?>
                                </div>
                                <?php if($references){ ?>
                                    <div id="references" class="tab-pane fade" role="tabpanel" aria-labelledby="references-tab">
                                        <div class="row">
                                            <?php foreach( $references as $reference ){ ?>
                                                <div class="col-6 col-md-4 col-xl-3 my-row">
                                                    <a 
                                                        href="<?php echo $reference['url']; ?>" 
                                                        data-caption="<?php echo $reference['caption']; ?>" 
                                                        alt="<?php echo $reference['alt']; ?>"
                                                        data-fancybox="chapter-references"
                                                        data-width="<?php echo $reference['width']; ?>"
                                                        data-height="<?php echo $reference['height']; ?>"
                                                        data-thumb="<?php echo $reference['sizes']['thumbnail']; ?>"
                                                        data-src="<?php echo $reference['sizes']['thumbnail']; ?>"
                                                        class="bg-img bg-cover p-ar-1x1 lazy"
                                                    >
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php /*if($homework){ ?>
                                    <div id="homework" class="tab-pane fade" role="tabpanel" aria-labelledby="homework-tab">
                                        <?php echo $homework; ?>
                                    </div>
                                <?php }*/ ?>
                            </div>
                        </div>                        
                    </div>
                    <div class="order-md-first col-md-4 col-xl-3">
                        <?php if($videos){ ?>
                            <div class="nav videolessons-videos d-block" id="videolessons-videos">
                                <?php foreach($videos as $index => $video){ $tab_nr = $index+1; ?>

                                    <?php 
                                        // $video_json = file_get_contents("http://vimeo.com/api/v2/video/" . $video["goicc_videolessons_videos_id"] . ".json");
                                        // $video_data = json_decode($video_json, true);
                                        // $video_thumb = str_replace('http:','https:', $video_data[0]['thumbnail_small']);

                                        $video_json = file_get_contents("http://vimeo.com/api/oembed.json?url=https%3A//vimeo.com/" . $video["goicc_videolessons_videos_id"]);
                                        $video_data = json_decode($video_json, true);
                                        $video_thumb = str_replace('http:','https:', $video_data['thumbnail_url']);
                                        $video_duration = $video_data['duration'];
                                        $video_title = $video_data['title'];
                                    ?>
                                    
                                    <div 
                                        data-toggle="tab" 
                                        data-target="#video-<?php echo $tab_nr; ?>"
                                        data-index="<?php echo $tab_nr; ?>"
                                        data-id="<?php echo $video["goicc_videolessons_videos_id"]; ?>"
                                        data-title="<?php echo $video_title /* $video["goicc_videolessons_videos_title"]*/ ; ?>"
                                        class="element row no-gutters border-bottom border-left border-right <?php if($index === 0){echo 'border-top';} ?>"
                                    >
                                        <div class="col-3 p-2">
                                            <div class="bg-img p-ar-3x2 bg-cover lazy thumbnail" 
                                                data-src="<?php echo $video_thumb; ?>"
                                                <?php /*data-src="https://img.youtube.com/vi/<?php echo $video["goicc_videolessons_videos_id"]; ?>/default.jpg" */ ?>
                                            >
                                            </div>
                                        </div>
                                        <div class="col-6 py-2 small">
                                            <?php echo /*$tab_nr . '. ' . */ $video_title /* $video["goicc_videolessons_videos_title"] */ ; ?>
                                        </div>
                                        <div class="col-3 p-2 small text-right">
                                            <?php echo seconds_to_time($video_duration /*$video["goicc_videolessons_videos_duration"]*/); ?>                                
                                        </div>
                                    </div>
                                    
                                <?php }?>
                            </div>
                        <?php }?>
                    </div>
                </div>

                <?php if(count($related_videolessons) > 1 ){ ?>
                    <hr class="my-4">
                    <div class="navigation row">
                        <div class="col-6 text-left prev">
                            <?php $prev_index = $current_index-1; if($prev_id = $related_videolessons[$prev_index]){ 
                                echo chapters_navigation($current_index, $prev_id, true);
                            } ?>
                        </div>
                        <div class="col-6 text-right next">
                            <?php $next_index = $current_index+1; if($next_id = $related_videolessons[$next_index]){ 
                                echo chapters_navigation($current_index, $next_id, false);
                            } ?>
                        </div>
                    </div>
                <?php } ?>
            </article>

        <?php }
    } 
}else{ 
?>

<p>
    <?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?>
</p>

<?php } ?>

<?php get_footer(); ?>