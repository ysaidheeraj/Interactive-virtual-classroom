var express = require('express')
var bodyParser = require('body-parser')
var app = express()
var http = require('http').Server(app)
var io = require('socket.io')(http)
var mongoose = require('mongoose')

let broadcaster

app.use(express.static(__dirname))
app.use(bodyParser.json())
app.use(bodyParser.urlencoded({ extended: false }))
//for canvas
app.use("/js", express.static(__dirname + "/js"))

//for video calling
app.use(express.static(__dirname + '/webrtc-video-broadcast-master/public'))

mongoose.Promise = Promise

var dbUrl = 'mongodb://192.168.31.166:27017/messages'

var Message = mongoose.model('Message', {
    course: String,
    name: String,
    message: String
})

app.get('/messages/:course', (req, res) => {
    res.header("Access-Control-Allow-Origin", "*")
        res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept")

    Message.find({course:req.params.course}, (err, messages) =>{
        res.send(messages)
    })
})

//canvas
app.get("/", function(req, res) {
    res.sendFile(__dirname + "/canvas.html");
    res.sendFile(__dirname + "/canvas1.html");
})

app.post('/messages', async (req, res) => {
    
    try {
        var message = new Message(req.body)

        var savedMessage= await message.save()
    
        //console.log('saved')
        var censored= await Message.findOne({message: 'badword'})
  
        if(censored) {
            await Message.remove({_id: censored.id})
        }
        else
           io.emit('message', req.body)
        
        res.sendStatus(200)
        
    } catch (error) {
        res.sendStatus(500)
        return console.error(error)
        
    }

})



io.on('connection', (socket) => {
    console.log('a user connected')
    socket.on("draw", function(data) {
        socket.broadcast.emit("draw", data)
      })
      socket.on("draw begin path", function() {
        socket.broadcast.emit("draw begin path")
      })
      socket.on('refresh', function () {
        socket.broadcast.emit('refresh');
    });
})


//for video chat
io.sockets.on('error', e => console.log(e))
io.sockets.on('connection', function (socket) {
  socket.on('broadcaster', function () {
    broadcaster = socket.id;
    socket.broadcast.emit('broadcaster')
  })
  socket.on('watcher', function () {
    broadcaster && socket.to(broadcaster).emit('watcher', socket.id)
  })
  socket.on('offer', function (id /* of the watcher */, message) {
    socket.to(id).emit('offer', socket.id /* of the broadcaster */, message)
  })
  socket.on('answer', function (id /* of the broadcaster */, message) {
    socket.to(id).emit('answer', socket.id /* of the watcher */, message)
  })
  socket.on('candidate', function (id, message) {
    socket.to(id).emit('candidate', socket.id, message)
  })
  socket.on('disconnect', function() {
    broadcaster && socket.to(broadcaster).emit('bye', socket.id)
  })
})

mongoose.connect(dbUrl, (err) => {
    console.log('mongo db connection', err)
})

var server = http.listen(3000, '192.168.31.166',() => {
    console.log('server is listening on port', server.address())
})