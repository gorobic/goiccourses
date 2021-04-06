(function ($) {

    jQuery(document).ready(function () {
        fullVideoBackground();
    });

    jQuery(window).resize(function () {
        fullVideoBackground();
    });

    /*document.addEventListener('DOMContentLoaded', function(){
        document.querySelector('.preloader').style.display = 'none';
    });*/

    $('.lazy').Lazy();

    function fullVideoBackground(){
        let $videoWraps = document.querySelectorAll('[data-videobg]');
        if($videoWraps.length){
            $videoWraps.forEach(function($el){
                let ratio = $el.dataset.ratio;
                if(!ratio) ratio = 56.25;
                let $child = $el.querySelector('iframe'); 
                let elWidth = $el.offsetWidth;
                let elHeight = $el.offsetHeight;
                let elRatio = elHeight * 100 / elWidth;

                if(ratio > elRatio){
                    // width = parent and height bigger
                    $child.style.height = (elWidth * ratio / 100) + 'px';
                    $child.style.width = elWidth + 'px'; 
                }else{
                    // height = parent and width bigger
                    $child.style.height = elHeight + 'px';
                    $child.style.width = (elHeight * 100 / ratio) + 'px';
                }
            });
        }
    }

})(jQuery);

function printPartOfPage(id){
    var prtContent = document.getElementById(id);
    var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.close();
    WinPrint.setTimeout(function(){
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
      }, 1000);
}