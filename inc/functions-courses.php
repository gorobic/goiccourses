<?php 

// Seconds to time
function seconds_to_time($t = 0, $has_icon = false){
    $seconds = $t % 60;
    $minutes = ($t - $seconds ) / 60 % 60;
    $hours = ($t - $seconds - ($minutes*60)) / 3600;
    
    $output = '';
    if($has_icon) $output = '<span class="goicicons-time mr-1"></span> ';

    if($hours > 0){
        $output .= $hours . "h ";
    }
    if($minutes > 0 || $hours > 0){
        $output .= $minutes . "m ";
    }
    if($seconds > 0 || $minutes > 0 || $hours > 0){
        $output .= $seconds . "s";
    }

    return $output;
}

function chapters_number_format($c = 0){
    return sprintf( _n( '%s chapter', '%s chapters', $c, 'goicc' ), $c );
}

function chapters_navigation($i = 0, $id = 0, $prev = false){
    if($id){
        if($prev){
            $number_in_title = $i;
        }else{
            $number_in_title = $i+2;
        }
        $title = $number_in_title . '. ' . get_the_title($id);
        ob_start();
    ?>
        <a href="<?php echo esc_url( get_the_permalink($id) ); ?>" title="<?php echo $title; ?>" class="small text-muted">
            <span class="thumbnail bg-img bg-cover p-ar-3x2 lazy d-inline-block" data-src="<?php if($post_thumbnail = get_the_post_thumbnail_url($id, 'medium')){ echo $post_thumbnail; } ?>" ></span>
            <br>
            <span>
                <?php if($prev){
                    _e('Previous chapter','goicc');
                }else{
                    _e('Next chapter','goicc');
                } ?>:
                <br>
                <?php echo $title; ?>
            </span>
        </a>
    <?php 
    }
    return ob_get_clean();
}