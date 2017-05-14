var ObjectID = require('mongodb').ObjectID,
  db = require('../db')

exports.all = function (cb) {
  db.get().collection('courses').find().toArray(function (err, docs) {
    cb(err, docs)
  })
}

exports.findById = function (id, cb) {
  db.get().collection('courses').findOne({ _id: ObjectID(id) }, function (err, doc) {
    cb(err, doc)
  })
}

exports.create = function (course, cb) {
  db.get().collection('courses').insert(course, function (err, result) {
    cb(err, result)
  })
}

exports.update = function (id, newData, cb) {
  db.get().collection('courses').updateOne(
    { _id: ObjectID(id) },
    newData,
    function (err, result) {
      cb(err, result)
    }
  )
}

exports.delete = function (id, cb) {
  db.get().collection('courses').deleteOne(
    { _id: ObjectID(id) },
    function (err, result) {
      cb(err, result)
    }
  )
}
