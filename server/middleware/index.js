module.exports = function (app, express, db) {
  var path = require('path'),
    helmet = require('helmet'),
    bodyParser = require('body-parser'),
    favicon = require('serve-favicon'),
    router = require('../routers/index'),
    exphbs = require('express-handlebars'),
    session = require('cookie-session')

  // disable wappalyzer
  app.disable('x-powered-by')

  // view engine setup
  app.engine('.hbs', exphbs(
    {
      extname: '.hbs',
      layoutsDir: 'server/views/layouts/',
      defaultLayout: 'index',
      partialsDir: 'server/views/partials/',
      helpers: {
        compare: function (lvalue, operator, rvalue, options) {
          var operators, result

          if (arguments.length < 3) {
            throw new Error("Handlerbars Helper 'compare' needs 2 parameters")
          }

          if (options === undefined) {
            options = rvalue
            rvalue = operator
            operator = '==='
          }

          operators = {
            '==': function (l, r) { return l == r },
            '===': function (l, r) { return l === r },
            '!=': function (l, r) { return l != r },
            '!==': function (l, r) { return l !== r },
            '<': function (l, r) { return l < r },
            '>': function (l, r) { return l > r },
            '<=': function (l, r) { return l <= r },
            '>=': function (l, r) { return l >= r },
            'typeof': function (l, r) { return typeof l === r }
          }

          result = operators[operator](lvalue, rvalue)

          if (result) {
            return options.fn(this)
          } else {
            return options.inverse(this)
          }
        },
        inc: function(number, options){
          if(typeof(number) === 'undefined' || number === null) return null;

          // Increment by inc parameter if it exists or just by one
          return parseInt(number) + 1;
        }
      }
    }

  ))
  app.set('view engine', '.hbs')
  app.set('views', path.join(__dirname, '../views'))

  // logger
  app.use(function (req, res, next) {
    console.log('%s %s', req.method, req.url)
    next()
  })

  // app.use(express.static(__dirname + '/client'));
  // app.use(helmet());
  app.use(express.static(path.join(__dirname, '../../client')))
  app.use('/client', express.static(path.join(__dirname, '../../client')))
  app.use(favicon(__dirname + '/../../client/media/favicon.ico'))

  app.use(bodyParser.json())
  app.use(bodyParser.urlencoded({ extended: true }))

  var expiryDate = new Date(Date.now() + 60 * 60 * 1000) // 1 hour
  // app.set('trust proxy', 1);
  app.use(session({
    name: 'admin_session',
    proxy: true,
    secret: 'keyboard cat',
    // resave: false,
    // saveUninitialized: true,
    // cookie: { secure: true },
    expires: expiryDate,
    maxAge: 3600000
  }))

  router(app, db)
}
