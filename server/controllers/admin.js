var Courses = require('../models/course'),
  Admin = require('../models/admin'),
  _admin = {
    login: 'admin',
    password: '1'
  },
  secureKey = 'megaSecureKeyForSession1832March162017'

exports.login = function (request, response) {
  var login = _admin.login === request.body.login
  var password = _admin.password === request.body.password

  console.log(login, password)

  if (login && password) {
    request.session.views = secureKey

    console.log(request.session.views)
    response.send('1')
    // response.sendStatus(200);
  } else {
    response.sendStatus(500)
  }
}

exports.logout = function (request, response) {
  request.session.views = null
  response.send('1')
}

exports.update = function (request, response) {
  Admin.update(
    request.params.id,
    {
      name: request.body.name,
      addr: request.body.addr,
      tel: request.body.tel,
      email: request.body.email,
      fb: request.body.fb,
      vk: request.body.vk,
      goo: request.body.goo
    },
    function (err, result) {
      if (err) {
        consoe.log(err)
        return response.sendStatus(500)
      }

      // response.sendStatus(200);
      response.send(result)
    })
}

exports.index = function (request, response) {
  console.log('Session debug: ', request.session.views, ' / ', secureKey)

  if (request.session.views === secureKey) {
    var coursesList, adminData

    Courses.all(function (err, docs) {
      if (err) {
        console.log(err)
        return response.sendStatus(500)
      }
      coursesList = docs

      Admin.findByName(function (err, docs) {
        if (err) {
          console.log(err)
          return response.sendStatus(500)
        }
        // adminData = docs;

        response.render('pages/admin', {
          showMenu: false,
          showLogout: true,
          users: docs,
          courses: coursesList
        })
      },
        'admin')
    })
  } else {
    response.render('pages/login', {
      showMenu: false,
      showLogout: false
    })
  }
}
