<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Classroom</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="SimpleRTC-gh-pages/stylesheets/style.css" />
    <link rel="stylesheet" type="text/css" href="SimpleRTC-gh-pages/fonts/font-awesome-4.3.0/css/font-awesome.min.css" />
    <script src="SimpleRTC-gh-pages/js/modernizr.custom.js"></script>
	<link rel="stylesheet" type="text/css" href="SimpleRTC-gh-pages/stylesheets/normalize.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="http://localhost:3000/socket.io/socket.io.js"></script>	


<style>
iframe {
width: 480px;
height: 150px;
background-color: #d0d0e1; 
overflow: scroll;
} 
body {
    background: #d0d0e1;
}
</style>
</head>
<body>
	<!-- Top navigation bar -->
	<nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top">
  <a class="navbar-brand" href="#">Interactive Virtual Classroom</a>
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
  <li class="nav-item">
      <a class="nav-link" href="logout.php">Logout</a>
	</li>
    </ul>
</nav>
<br><br><br>
	<div class = "bodyDiv">


	<div id="container" style="width:100%;">  
		<div id="left" style="float:left; width:60%;">
		<iframe style="width: 800px; height: 600px;" frameBorder="0" src="http://localhost:3000/canvas.html"></iframe>
		
			
		
		</div>                                
  <div id="right" style="float:right; width:40%;">
	<div class = "bodyDiv">

		<!-- =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= -->
		<!-- My Phone Number & Dial Areas -->
		<!-- =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= -->
		
			
		<div id="vid-box"></div>
			
			
		 <div id="stream-info" hidden="true">
				<button id="end" onclick="end()" hidden="true">Done</button>
				<img src="SimpleRTC-gh-pages/img/person_dark.png"/>
				<span id="here-now">0</span>       
		</div> 
		
		<?php
			require 'database.php';
			session_start();
			$name=$_SESSION['user_id'];
			$course=$_SESSION['course'];
			if($_SESSION['category']=='Professor'):
				$rs=mysql_query("select course_id from faculty_courses where faculty_id= '$name'",$cn) or die(mysql_error());
				echo'
		<form name="streamForm" id="stream" action="#" onsubmit="return errWrap(stream,this);">
			<input name="streamname" type="hidden" value="'.$course.'"/>
		
			  <button onClick = "this.style.visibility= `hidden`;" title="Create Stream" class="cbutton cbutton--effect-radomir" type="submit" value="Stream" name="stream_submit" style="margin-top: 40px; margin-left:-10px">
					<i class="cbutton__icon fa fa-fw fa fa fa-video-camera"></i>
				</button>
		</form>';
		  
		else:
			$name=$_SESSION['user_id'];
			$rs=mysql_query("select course_id from student_courses where student_id= '$name'",$cn) or die(mysql_error());
			 //while($row=mysql_fetch_row($rs)){
			//echo '<option value='.$row[0].' >'.$row[0].'</option>';}
			//echo
			echo'
		<form name="watchForm" id="watch" action="#" onsubmit="return errWrap(watch,this);">
				<input name="number" type="hidden" value="'.$course.'"/>
			
		
			   <button onClick = "this.style.visibility= `hidden`;" title="Join Stream" class="cbutton cbutton--effect-radomir" type="submit" value="Watch" style="margin-top: 0px; margin-left:-10px;">
						<i class="cbutton__icon fa fa-fw fa fa-eye"></i>
				</button>
		</form>';
		endif;
		?>  
			
		<div id="inStream" class="ptext">
			<!--Embed Style: <button onclick="genEmbed(400,600)">Tall</button><button onclick="genEmbed(600,400)">Wide</button><button onclick="genEmbed(500,500)">Square</button><br>-->
			<div id="embed-code"></div>
			<div id="embed-demo"></div>
		</div>
			
		<!--<div id="logs" class="ptext"> style="background-color:white"></div>-->
	</div>
	<!--<div class="container">-->
    <br>
    <div class="jumbotron" style="width: 540px; height: 500px;">
        <h5>Class chat</h5>
        <input type="hidden" id="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>">
        <br>
        <textarea id="output" class="form-control" placeholder="Message"></textarea>
        <br>
		<button id="send" class="btn btn-success">Send</button>
        <input type="button" value="Clear" class="btn btn-success" onclick="javascript:eraseText();">
    <br><br>
	<table>
	<tr>
	<td>
	Online
	<iframe frameBorder="0" class="form-control" style="width: 200px;height: 150px;" src="chatterBox/chatroom.php"></iframe>
		</td>
		<td>
		Chats
		<div id="messages" class="form-control" align="left" style="width: 300px;height: 150px;overflow: scroll;"></div>
		<!--<iframe frameBorder="0" class="form-control" src="http://localhost:3000"></iframe>-->
		</td>
		</tr>
	</table>
    </div>
<!--</div>-->

</div>

<!--<div class="ptext">
    <p><b>To Use:</b></p>
    <p>Type a channel to stream to and click Stream.</p>
    <p>In a separate browser window, join the steam you created.</p>
</div>-->
<!-- =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- -->
<!-- WebRTC Peer Connections -->
<!-- =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- -->

<script>
    var socket=io();
    $(() => {
        $("#send").click(()=>{
            var message={name: $("#name").val(),message: $("#output").val()};
            postMessages(message);
        })
        getMessages();
    })

    socket.on('message',addMessages);

    function eraseText() {
		document.getElementById("output").value = "";
		//for Popups
		//popupWindow = window.open('/project/index.php', 'name', 'width=700,height=350');
		//popupWindow.focus();
    }
    function addMessages(message){
        $("#messages").append(`<b> ${message.name} </b>: ${message.message}<br>`);
    }

    function getMessages(){
        $.get('http://localhost:3000/messages',(data)=>{
            data.forEach(addMessages)
        });
    }

    function postMessages (message) {
        $.post('http://localhost:3000/messages',message);
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdn.pubnub.com/pubnub.min.js"></script>
<script src="SimpleRTC-gh-pages/js/webrtc.js"></script>
<script src="SimpleRTC-gh-pages/js/rtc-controller.js"></script>

<script type="text/javascript">

var video_out  = document.getElementById("vid-box");
var embed_code = document.getElementById("embed-code");
var embed_demo = document.getElementById("embed-demo");
var here_now   = document.getElementById('here-now');
var stream_info= document.getElementById('stream-info');
var end_stream = document.getElementById('end');

var streamName;

function stream(form) {
	streamName = form.streamname.value || Math.floor(Math.random()*100)+'';
	var phone = window.phone = PHONE({
	    number        : streamName, // listen on username line else random
	    publish_key   : 'pub-c-561a7378-fa06-4c50-a331-5c0056d0163c', // Your Pub Key
	    subscribe_key : 'sub-c-17b7db8a-3915-11e4-9868-02ee2ddab7fe', // Your Sub Key
	    oneway        : true,
	    broadcast     : true
	});
	//phone.debug(function(m){ console.log(m); })
	var ctrl = window.ctrl = CONTROLLER(phone);
	ctrl.ready(function(){
		form.streamname.style.background="#55ff5b";
		form.streamname.value = phone.number(); 
//		form.stream_submit.hidden="true"; 
		ctrl.addLocalStream(video_out);
		ctrl.stream();
        stream_info.hidden=false;
        end_stream.hidden =false;
		addLog("Streaming to " + streamName); 
	});
	ctrl.receive(function(session){
	    session.connected(function(session){ addLog(session.number + " has joined."); });
	    session.ended(function(session) { addLog(session.number + " has left."); console.log(session)});
	});
	ctrl.streamPresence(function(m){
		here_now.innerHTML=m.occupancy;
		addLog(m.occupancy + " currently watching.");
	});
	return false;
}

function watch(form){
	var num = form.number.value;
	var phone = window.phone = PHONE({
	    number        : "Viewer" + Math.floor(Math.random()*100), // listen on username line else random
	    publish_key   : 'pub-c-561a7378-fa06-4c50-a331-5c0056d0163c', // Your Pub Key
	    subscribe_key : 'sub-c-17b7db8a-3915-11e4-9868-02ee2ddab7fe', // Your Sub Key
	    oneway        : true
	});
	var ctrl = window.ctrl = CONTROLLER(phone);
	ctrl.ready(function(){
		ctrl.isStreaming(num, function(isOn){
			if (isOn) ctrl.joinStream(num);
			else alert("User is not streaming!");
		});
		addLog("Joining stream  " + num); 
	});
	ctrl.receive(function(session){
	    session.connected(function(session){ 
            video_out.appendChild(session.video); 
            addLog(session.number + " has joined.");
            stream_info.hidden=false;
        });
	    session.ended(function(session) { addLog(session.number + " has left."); });
	});
	ctrl.streamPresence(function(m){
		here_now.innerHTML=m.occupancy;
		addLog(m.occupancy + " currently watching.");
	});
	return false;
}

function getVideo(number){
	return $('*[data-number="'+number+'"]');
}

function addLog(log){
	$('#logs').append("<p>"+log+"</p>");
}

function end(){
	if (!window.phone) return;
	ctrl.hangup();
    video_out.innerHTML = "";
//	phone.pubnub.unsubscribe(); // unsubscribe all?
}

function genEmbed(w,h){
	if (!streamName) return;
	var url = "http://kevingleason.me/SimpleRTC/embed.html?stream=" + streamName;
	var embed    = document.createElement('iframe');
	embed.src    = url;
	embed.width  = w;
	embed.height = h;
	embed.setAttribute("frameborder", 0);
	embed_demo.innerHTML = "<a href='SimpleRTC-gh-pages/embed_demo.html?stream="+streamName+"&width="+w+"&height="+h+"'>Embed Demo</a>" 
	embed_code.innerHTML = 'Embed Code: ';
	embed_code.appendChild(document.createTextNode(embed.outerHTML));
}

function errWrap(fxn, form){
	try {
		return fxn(form);
	} catch(err) {
		alert("WebRTC is currently only supported by Chrome, Opera, and Firefox");
		return false;
	}
}

</script>

<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new
		Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-46933211-3', 'auto');
	ga('send', 'pageview');

</script>

</div>
</body>
</html>
