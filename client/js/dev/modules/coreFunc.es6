export function createCookie (name, value, days) {
  var expires

  if (days) {
    var date = new Date()
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000))
    expires = '; expires=' + date.toGMTString()
  } else {
    expires = ''
  }
  document.cookie = name + '=' + value + expires + '; path=/'
}

export function readCookie (name) {
  var nameEQ = name + '='
  var ca = document.cookie.split(';')
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i]
    while (c.charAt(0) === ' ') { c = c.substring(1, c.length) }
    if (c.indexOf(nameEQ) === 0) { return c.substring(nameEQ.length, c.length) }
  }
  return null
}

export function eraseCookie (name) {
  createCookie(name, '', -1)
}

export function counter () {
  $('.js-counter').each(function () {
    $(this).prop('count', 0).animate({
      count: $(this).text()
    }, {
      duration: 2000,
      easing: 'swing',
      step: function (now) {
        $(this).text(Math.ceil(now))
      }
    })
  })
}

export function getTimeRemaining (endtime) {
  let t = Date.parse(endtime) - Date.parse(new Date())
  let days = Math.floor(t / (1000 * 60 * 60 * 24))

  return days
}
