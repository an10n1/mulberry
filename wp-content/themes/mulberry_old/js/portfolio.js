(function($) {

  'use strict';


  $(window).load(function(){
    // Container
    var $container = $('.isotope-container');
    $container.isotope({
      filter:'*',
      animationOptions: {
        duration: 750,
        easing: 'linear',
        queue: false,
      }
    });

    // Isotope Button
    $('#options li a').click(function(){
      var selector = $(this).attr('data-filter');
      $container.isotope({
        filter:selector,
        animationOptions: {
          duration: 750,
          easing: 'linear',
          queue: false,
        }
      });
      return false;
    });

    var $optionSets = $('#options'),
      $optionLinks = $optionSets.find('a');

      $optionLinks.click(function(){
        var $this = $(this);
        // don't proceed if already selected
        if ($this.hasClass('selected')) {
          return false;
        }
        var $optionSet = $this.parents('#options');
        $optionSet.find('.selected').removeClass('selected');
        $this.addClass('selected'); 
      });


// Infinite Scroll
    $container.infinitescroll({
        loading: {
    finishedMsg: 'There is no more',
    msgText: 'loading',
    speed: 'normal'
        },

    state: {
    isDone: false
    },
        navSelector  : '#portfolio-nav', 
        nextSelector : '#portfolio-nav .nav-previous a', 
        itemSelector : '.foliobox',

    },
    
    // Infinite Scroll Callback
    function( newElements ) {
$container.isotope( 'appended', $( newElements ) );
var t = setTimeout( function(){ $container.isotope('layout'); }, 2000 );

    });

$container.infinitescroll('unbind');
  $("#load-infinite").click(function(){
        $container.infinitescroll('retrieve');
         return false;

    });

  });

})( jQuery );