(function($) {

	'use strict';


/*-----------------------------------------------------------------------------------*/
/*  Initialize
/*-----------------------------------------------------------------------------------*/  

new WOW().init();


$(window).scrollTop();
    $(window).scroll(function() {
      if ($(this).scrollTop() > 20){  
        $('.site-header').addClass("fixedwrap");
      }
      else{
        $('.site-header').removeClass("fixedwrap");
      }
    });

    $(window).load(function() { 
        $('#status').fadeOut(); 
        $('#preloader').delay(350).fadeOut('fast'); 
        $('body').delay(350).css({'overflow':'visible'});

    });

    
$(document).ready(function() {

  var headHeight = $('.site-header').height();
  var wrapHeight = $('#content-wrapper').height();

  $('#content-wrapper').css('padding-top', headHeight + 80);


/*-----------------------------------------------------------------------------------*/
/*  Menu Button
/*-----------------------------------------------------------------------------------*/  

$('.burger').click(function() {
    $('.site-header nav.menu').toggleClass('mobile-menu');
    $('.burger').toggleClass('active');
});


/*-----------------------------------------------------------------------------------*/
/*  Flexslider
/*-----------------------------------------------------------------------------------*/  
$(".flex-wrapper .flexslider").flexslider( {
                slideshow : true,
                animation : "fade",
                pauseOnHover: true,
                animationSpeed : 400,
                smoothHeight : true,
                directionNav: true,
                controlNav: false

});  

});
// document ready end

})( jQuery );