var Contact = require('../models/contact'),
    nodemailer = require('nodemailer');

exports.index = function(request, response){
  Contact.index(request.body, function(data){

    // create reusable transporter object using the default SMTP transport
    var transporter = nodemailer.createTransport({
        service: 'gmail',
        auth: {
            user: data.authEmail,
            pass: data.authPass
        }
    });

    // setup email data with unicode symbols
    var mailOptions = {
        from: data.authEmail, // sender address
        to: data.clientEmail, // list of receivers
        subject: data.subjectEmail, // Subject line
        html: data.msg // html body
    };

    // send mail with defined transport object
    transporter.sendMail(mailOptions, (error, info) => {
        if (error) {
            console.log(error);
            return response.sendStatus(500);
        }
        console.log('Message %s sent: %s', info.messageId, info.response);
        response.sendStatus(200);
    });

  });
}
