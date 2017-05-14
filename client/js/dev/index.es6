/* Mulberry
 * Owner: Anton Ashin
 * http://www.fintegro.com
 * Released under the MIT license
 *
 *
 * Author: Anton Ashin
 * http://www.antonashin.pp.ua
 *
 * Date: 2017-02-26
 */

import $ from 'jquery'

$(document).ready(() => {
  const BODY = $('body')

  function HOMESCREEN () {
    //const ANIM = require('./modules/animation.es6')
    //const CONTACT = require('./modules/contacts.es6')
    //const MAP = require('./modules/googleMap.es6')
    //const COURSE = require('./modules/course.es6')
    //const dom = require('./modules/DOM.es6')

    setTimeout(() => {
      if (Modernizr.touchevents) {
        BODY.css('opacity', '1')

        $(window).on('orientationchange', function () {
          if ($(window).width() > 576) {
            if (!localStorage.getItem('scroll')) {
              localStorage.setItem('scroll', (window.pageYOffset))
              location.reload()
            }
          }
        })
      } else {
        require.ensure([], (require) => {
          BODY.animate({opacity: '1'}, 250)

          //dom().mediaTeacherSVG()
        })
      }

      $(window).resize(function () {
        //ANIM().scrolltop()
      })

      if ($(window).width() > 576) {
        //const CAROUSEL = require('./modules/carousel.es6')
        //CAROUSEL(BODY).firstCarousel()
        //dom().mediaTeacherSVG()
      }

      //ANIM(BODY).events()
      //COURSE(BODY).Events()

      require('jquery.easing')

      //CONTACT(BODY)

      //MAP()
    }, 750)
  }

  if (location.pathname === '/admin' || location.pathname === '/login') {
    require.ensure([], (require) => {
      require('../../scss/layout/_l-admin.scss')

      let ADMIN = require('./admin.es6')
      ADMIN(BODY).Event()

      setTimeout(() => {
        BODY.animate({opacity: '1'}, 250)
      }, 750)
    })
  } else {
    require('../../scss/layout/_l-intro.scss')

    BODY.animate({opacity: '1'}, 250)

    setTimeout(() => {
      $.ajax({
        url: '/home',
        type: 'GET',
        success: (response) => {
          $('#preloader').after(response)

          setTimeout(() => {
            HOMESCREEN()

            if (localStorage.getItem('scroll')) {
              let dScroll = localStorage.getItem('scroll')
              let trashAnimTop = $('.s_teacher').offset().top
              let trashAnimBottom = trashAnimTop + $('.s_teacher').height()

              if (dScroll > trashAnimTop && dScroll < trashAnimBottom) {
                console.log('Ok')
              }
              $('html, body').animate({
                scrollTop: localStorage.getItem('scroll')
              }, 250)

              localStorage.removeItem('scroll')
            }

            setTimeout(() => {
              $('#preloader').remove()
            }, 1000)
          }, 750)
        }
      })
    }, 1750)
  }
})
