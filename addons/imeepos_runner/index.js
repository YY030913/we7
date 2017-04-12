
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var config = require('./config.js');
var query=require("./mysql.js");

app.get('/', function(req, res){
    res.send('<h1>welcome to imeepos runner !</h1>');
});
var onlineUsers = {};
var onlineCount = 0;
var maxshake  = 0;
var pnum = 0;
var game_status = 0;
var totalTime = 10;
var rotate_id = 0;

io.on('connection', function(socket){
    if(typeof socket.handshake.query.avatar != "undefined"){
        if(socket.handshake.query.avatar != ''){
            socket.name = socket.handshake.query.openid;
            if(!onlineUsers.hasOwnProperty(socket.handshake.query.openid)) {
                onlineUsers[socket.handshake.query.openid] =
                {
                    openid:socket.handshake.query.openid,
                    nickname:socket.handshake.query.nickname,
                    avatar:socket.handshake.query.avatar,
                    count:0,
                    createtime:0,
                };
                onlineCount++;
                io.emit('new player', {count:onlineCount,rotate_id:rotate_id,new_player:onlineUsers[socket.handshake.query.openid]});
            }else{
                onlineUsers[socket.name].count = 0;
                onlineUsers[socket.name].createtime = 0;
                io.emit('new player', {count:onlineCount,rotate_id:rotate_id,new_player:onlineUsers[socket.handshake.query.openid]});
            }
        }
    }
    if(socket.handshake.query.rotate_id != "undefined"){
        if(rotate_id!=socket.handshake.query.rotate_id){
            onlineCount=0;
            onlineUsers = {};
        }
        rotate_id = socket.handshake.query.rotate_id;
    }
    socket.on('screen init', function(e){
        game_status=0;
        for(var i in onlineUsers){
            if (typeof onlineUsers[i].count != "undefined" ){
                onlineUsers[i].count = 0;
            }
            if (typeof onlineUsers[i].createtime != "undefined" ){
                onlineUsers[i].createtime = 0;
            }
        }
        io.emit('screen init',{user:onlineUsers});
    });
    socket.on('init', function(data){
        var init = {running:game_status};
        if(game_status==0){
        }else{
            init.count=totalTime;
        }
        init.persons=onlineCount;
        init.rotate_id=rotate_id;
        if(onlineUsers.hasOwnProperty(socket.name)){
            init.new_player=onlineUsers[socket.name];
            init.score = onlineUsers[socket.name].count;
            init.openid = socket.name;
        }
        console.log(socket.name+'初始化了');
        io.emit('init',init);
    });
    socket.on('start', function(data){
        totalTime = data.count;//获取本次活动点数
        game_status = 1;//游戏状态改为开始
        io.emit('start',data);//告知本轮点数   
    });
    socket.on('shake', function(data){
        if(onlineUsers.hasOwnProperty(socket.name)) {
            var user = onlineUsers[socket.name];
            onlineUsers[socket.name].count = onlineUsers[socket.name].count+1;
        }
    });
    socket.on('rank', function(obj){
        io.emit('rank',{data:{'players':onlineUsers}});
    });
    socket.on('game over', function(obj){
        game_status = 0;
        io.emit('game over',{rotate_id:rotate_id,data:onlineUsers});
    });
    socket.on('player_had_done', function(obj){
        if(onlineUsers.hasOwnProperty(socket.name)) {
            if(onlineUsers[socket.name].createtime===0){
                onlineUsers[socket.name].createtime = parseInt(new Date().getTime());
            }
        }
    });
    socket.on('reset', function(data){
        game_status=0;
        if(data.rotate_id != rotate_id){
            onlineCount=0;
            if (typeof onlineUsers != "undefined") {
                for(var i in onlineUsers){
                    onlineUsers[i].count=0;
                    onlineUsers[i].createtime=0;
                }
            }
        }
        io.emit('refresh');
    });
    socket.on('disconnect', function(){
        if(onlineUsers.hasOwnProperty(socket.name)) {
            delete onlineUsers[socket.name];
            onlineCount--;
            io.emit('player disconnect', {openid:socket.name,onlineUsers:onlineUsers,count:onlineCount});
        }

    });
    socket.on('connect', function(data) {
        //连接成功事件，可以根据该事件渲染动画
        console.log("connect");

        socket.emit('init');//发送init事件
    });
});
http.listen(config.port, function(){
    console.log('listening on *:'+config.port);
});