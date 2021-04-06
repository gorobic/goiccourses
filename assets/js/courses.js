(function ($) {

    jQuery(document).ready(function () {
        let urlParams = new URLSearchParams(window.location.search);
        if(urlParams.has('video')){
            const urlVideo = urlParams.get('video');
            $(`.videolessons-videos .element[data-index="${urlVideo}"]`).tab('show');
        }

        $('[data-fancybox="chapter-references"]').fancybox({
            buttons: [
                "zoom",
                "fullScreen",
                "download",
                "thumbs",
                "close"
            ],
        });
    });


    jQuery(window).resize(function () {
        resizeLessonVideo();
    });

    $('.videolessons-videos .element').on('shown.bs.tab', function (e) {
        //e.target // newly activated tab
        //e.relatedTarget // previous active tab
        let $videoTitle = document.querySelector('#video-title');
        $videoTitle.innerText = `-  ${e.target.dataset.title}`;
        updateUrlOnVideoChange(e.target.dataset.index);
        loadLessonVideo(e.target.dataset.id);
        resizeLessonVideo();

        let $videoBox = document.querySelector('#video-box');
        $videoBox.scrollIntoView();
    });

    const $playFirstLessonVideoBtn = document.querySelectorAll('.videolessons-play-first-video');
    $playFirstLessonVideoBtn.forEach(function(el){
        el.addEventListener('click', function(event){
            $(`.videolessons-videos .element[data-index="1"]`).tab('show'); 
        });
    });

})(jQuery);

function updateUrlOnVideoChange(videoIndex){
    let urlParams = new URLSearchParams(window.location.search);
    urlParams.set('video', videoIndex);
    window.history.replaceState(null,null, "?"+urlParams.toString());
}

function loadLessonVideo(videoId){
    let $videoBox = document.querySelector('#video-box');
    $videoBox.innerHTML = `<iframe src="https://player.vimeo.com/video/${videoId}?loop=1&byline=0&title=0"
    frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen"></iframe>`;
    // de înlocuit conținutul videobox cu iframe cu video corespunzător și de aplicat acestuia lățimea și înălțimea responsive
}

function resizeLessonVideo(){
    let $videoBox = document.querySelector('#video-box');
    if(!$videoBox) return;
    
    let videoBoxWidth = $videoBox.offsetWidth;
    let $videoIframe = document.querySelector('#video-box iframe');
    let ratio = 56.25;

    $videoIframe.style.width = videoBoxWidth + 'px'; 
    $videoIframe.style.height = (videoBoxWidth * ratio / 100) + 'px';
}