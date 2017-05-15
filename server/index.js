var express = require('express'),
  app = express(),
  http = require('http'),
    // Uncoment for SSL
    // https = require('https'),
    // fs = require('fs'),
    // privateKey  = fs.readFileSync('/etc/apache2/ssl/apache.key', 'utf8'),
    // certificate = fs.readFileSync('/etc/apache2/ssl/apache.crt', 'utf8'),
    // credentials = { key: privateKey, cert: certificate },
  MongoClient = require('mongodb').MongoClient,
  db = require('./db'),
  middleware = require('./middleware/index')

app.set('port', (process.env.PORT || 5000))

var httpServer = http.createServer(app)
	// httpsServer = https.createServer(credentials, app);

db.connect('mongodb://localhost:27017/mulberry', function (err) {
  if (err) {
    return console.log(err)
  }

  httpServer.listen(app.get('port'), function () {
    console.log('Server running at :5000')
  })

    // httpsServer.listen(5443, function(){
    //     console.log('Server running at :443');
    // });

  middleware(app, express, db)
})
