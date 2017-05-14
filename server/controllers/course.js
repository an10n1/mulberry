var Courses = require('../models/course')

exports.all = function (request, response) {
  Courses.all(function (err, docs) {
    if (err) {
      console.log(err)
      return response.sendStatus(500)
    }
    response.send(docs)
  })
}

// exports.findById = function(request, response){
// 	Courses.findById(request.params.id, function(err, doc){
//     if(err){
//       console.log(err);
//       return response.sendStatus(500);
//     }
//     response.send(doc);
// 	});
// };

exports.create = function (request, response) {
  var course = {
    name: request.body.name,
    time: request.body.time,
    services: request.body.services,
    date: request.body.date,
    day: request.body.day,
    place: request.body.place,
    coast: request.body.coast,
    descr: request.body.descr,
    lessons: request.body.lessons,
    teacher: request.body.teacher
  }

  Courses.create(course, function (err, doc) {
    if (err) {
      consoe.log(err)
      return response.sendStatus(500)
    }

    response.send(course)
  })
}

exports.update = function (request, response) {
  Courses.update(
    request.params.id,
    {
      name: request.body.name,
      time: request.body.time,
      services: request.body.services,
      date: request.body.date,
      day: request.body.day,
      place: request.body.place,
      coast: request.body.coast,
      descr: request.body.descr,
      lessons: request.body.lessons,
      teacher: request.body.teacher
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

exports.delete = function (request, response) {
  Courses.delete(request.params.id, function (err, result) {
    if (err) {
      consoe.log(err)
      return response.sendStatus(500)
    }

    response.send(result)
  })
}
