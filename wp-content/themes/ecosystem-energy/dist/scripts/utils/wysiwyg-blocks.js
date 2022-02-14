/**
* Additionnal Script for Custom Gutenberg Block
* If you need script on custon gutenberg block use this file
*/


jQuery(document).ready(function( $ ) {
    /**
    * 
    * Script WYSIWYG Slider Block
    * Initialize each slider with Swiper.js
    * 
    */

   $(".content-slider-ctn").each(function(index, element){
        var $this = $(this);
        var swiperContainer = $this.find(".swiper-container");
        var navNext = $this.find(".swiper-button-next");
        var navPrev = $this.find(".swiper-button-prev");
        var pagination = $this.find(".swiper-pagination");    

        var videoSLider = new Swiper( swiperContainer, {
            speed: 400,
            loop:true,
            watchOverflow: true,
            pagination: {
                el: pagination,
                type: 'bullets',
                clickable: true,
            },
            navigation: {
                nextEl: navNext,
                prevEl: navPrev,
            }
        });
    });


    /**
    * 
    * Script WYSIWYG Accordion Block
    * OPEN / CLOSE method
    * 
    */

   $(".js-accordion").click( function (){
            
        if($(this).hasClass('open')){
            $(this).removeClass('open');
            $(this).find('.inner').height(0);
        }
        else{
            $(this).addClass('open');
            var realHeight = $(this).find('.inner div').outerHeight();
            $(this).find('.inner').height(realHeight);
        }
    });
});