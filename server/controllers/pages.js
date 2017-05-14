var Courses = require('../models/course')
var User = require('../models/admin')

exports.intro = function (req, res) {
  res.render('pages/intro', {
    // layout: false
  })
}

exports.home = function (req, res) {
  var coursesList

  Courses.all(function (err, docs) {
    if (err) {
      console.log(err)
      return res.sendStatus(500)
    }

    coursesList = docs

    User.findByName(function (err, docs) {
      if (err) {
        console.log(err)
        return res.sendStatus(500)
      }

      res.render('pages/home', {
        layout: false,
        showMenu: true,
        courses: coursesList,
        users: docs
      })
    })
  })
}

exports.coursePage = function (req, res) {
  var course = req.query.courseId

  Courses.all(function (err, docs) {
    Courses.findById(course, function (err, doc) {
      if (err) {
        console.log(err)
        return res.sendStatus(500)
      }

      if (!doc) {
        res.render('pages/error')
        return false
      }

      /*
       * Удалить этот код при добавлении в админку возможности загружать фото курса
       */
      var courseName = doc.name
      var variants = ['Верстка', 'Front', 'Back']
      var type

      for (var i = 0; i < variants.length; i++) {
        if (courseName.indexOf(variants[i]) + 1) {
          type = i
        }
      }

      /*
       * Конец говнокода
       */

      res.render('pages/course', {
        layout: false,
        courseData: doc,
        courseType: type,
        allCourses: docs
      })
    })
  })
}

exports.pages = function (req, res) {
  var page = req.params.page
  res.render('pages/error')
}
