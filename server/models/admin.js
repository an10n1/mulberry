var ObjectID = require('mongodb').ObjectID,
		db = require('../db');

exports.all = function(cb){
	db.get().collection('users').find().toArray(function(err, docs){
		cb(err, docs);
	});
}

exports.findByName = function(cb, name){
	if(!name){
		name = 'admin';
	}

	db.get().collection('users').findOne({ name: name }, function(err, doc){
		cb(err, doc);
	});
}

exports.update = function(name, newData, cb){
	db.get().collection('users').updateOne(
		{ name: name },
		newData,
		function(err, result){
    	cb(err, result)
		}
	);
}