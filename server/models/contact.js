exports.index = function (data, cb) {
  var msg,
    docs,
    authEmail = 'fintegrodev@gmail.com',
    authPass = 'Fintegro123123',
    clientEmail = 'real.it.ua@gmail.com',
    subjectEmail = 'Request from Real-IT school'

  if (data.form1) {
    msg = 'Вы получили новое сообщение с Вашего сайта IT-школы от:' +
          '<table>' +
          '<tr><th>Имя:</th><td>' + data.form1.name + '</td></tr>' +
          '<tr><th>Телефон:</th><td>' + data.form1.phone + '</td></tr>' +
          '<tr><th>Email:</th><td>' + data.form1.email + '</td></tr>' +
          '<tr><th>Сообщение:</th><td>' + data.form1.message + '</td></tr>' +
          '</table>'
  } else {
    msg = 'Вы получили новое сообщение (заявку на курс) с Вашего сайта IT-школы от:' +
      '<table>' +
      '<tr><th>Имя:</th><td>' + data.form2.name + '</td></tr>' +
      '<tr><th>Email:</th><td>' + data.form2.email + '</td></tr>' +
      '<tr><th>Телефон:</th><td>' + data.form2.phone + '</td></tr>' +
      '<tr><th>Название курса:</th><td>' + data.form2.courseName + '</td></tr>' +
      '</table>'
  }

  docs = {
    authEmail: authEmail,
    authPass: authPass,
    clientEmail: clientEmail,
    subjectEmail: subjectEmail,
    msg: msg
  }

  cb(docs)
}
