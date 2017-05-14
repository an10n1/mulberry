var ObjectID = require('mongodb').ObjectID,
  courseController = require('../controllers/course'),
  pageController = require('../controllers/pages'),
  adminController = require('../controllers/admin'),
  contactController = require('../controllers/contact')

module.exports = function (app, db) {
  app.get('/', pageController.intro)

  app.get('/home', pageController.home)

  app.get('/admin', adminController.index)

  app.get('/coursePage', pageController.coursePage)

  app.post('/login', adminController.login)

  app.put('/adminupdate/:id', adminController.update)

  app.post('/logout', adminController.logout)

  app.post('/contact', contactController.index)

  app.get('/courses', courseController.all)

  // app.get('/courses/:id', courseController.findById);

  app.post('/courses', courseController.create)

  app.put('/courses/:id', courseController.update)

  app.delete('/courses/:id', courseController.delete)

  app.get('/:page?', pageController.pages)
}
