var express = require('express')

var app = express()

var http = require('http').Server(app)

var bodyParser = require('body-parser');

app.use(bodyParser.json({limit: '1mb'}));  //这里指定参数使用 json 格式

app.use(bodyParser.urlencoded({

  extended: true

}));

var http_socket = require('http').Server(app);

var io = require('socket.io')(http_socket);

app.post('/test', function (req, res) {

	console.log(req.body.code)

	io.sockets.emit('push',req.body.msg)

   	res.send(req.body)

});

var usocket = {},user = [];

io.on('connection', function(socket){
	console.log(1111111)
/*    socket.on('login',function(user_id){
        if (!(user_id in usocket)) {
            socket.user_id = user_id;
            usocket[user_id] = socket;
            user.push(user_id);
            socket.emit('login',user);
            socket.broadcast.emit('newuser',user_id);
        }
        console.log(user);
    });
    socket.on('sendmsg', function(res){
        socket.emit('sendrightmsg', res.msg);
        if (res.user_id) {
            usocket[res.user_id].emit('sendleftmsg', res.msg);
        }
    });*/
    socket.on('disconnect', function () {
    	console.log(222222)
/*        if (socket.user_id in usocket) {
            delete(usocket[socket.user_id]);
            user.splice(user.indexOf(socket.user_id), 1);
            socket.broadcast.emit('someoneleave',socket.user_id);
        }*/
        console.log(socket.id + 'disconnect');
    });
});

http.listen(3000, function () {

    console.log('listening at port 3000')

});

http_socket.listen(3001, function () {

    console.log('listening at port 3001');

});