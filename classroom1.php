<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: /project/login.php");
    }
    ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Classroom</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="js/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://192.168.31.166:3000/socket.io/socket.io.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	


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
	<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Interactive Virtual Classroom</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav> 


    <div id="container" style="width:100%;">
		<div id="left" style="float:left; width:60%;">
        <?php
			//require 'database.php';
            //session_start();
            if($_SESSION['category']=='Professor'):
            echo'<iframe style="width: 805px; height: 540px;" frameBorder="0" src="http://192.168.31.166:3000/canvas.html"></iframe>
                <iframe style="width: 650px;" src="fileupload.php" frameborder="0"></iframe>';
            else:
                echo'<iframe style="width: 805px; height: 540px;" frameBorder="0" src="http://192.168.31.166:3000/canvas1.html"></iframe>
                    <iframe  style="width: 650px;" src="viewfilesstudent.php" frameborder="0"></iframe>';
                endif;
        ?>
	    </div>
    <div id="right" style="float:right; width:40%;">
    <?php
			require 'database.php';
			//session_start();
			$name=$_SESSION['user_id'];
			$course=$_SESSION['course'];
            if($_SESSION['category']=='Professor'):
                echo'<iframe style="width: 540px; height: 300px;" frameBorder="0" src="http://192.168.31.166:3000/broadcast.html"></iframe>';
            else:
                echo'<iframe style="width: 540px; height: 300px;" frameBorder="0" src="http://192.168.31.166:3000/client.html"></iframe>';
                endif;
            ?>
            <br>
            <center><h3>Class chat</h3></center>
           <div class="input-group">
                <input type="hidden" id="course" value="<?php echo htmlspecialchars($course); ?>">
                <input type="hidden" id="name" value="<?php echo htmlspecialchars($name); ?>">
                <textarea id="output" class="form-control" placeholder="Message" style="height:50px;"></textarea>     
                <span id="send" class="input-group-addon btn btn-primary">Send</span>
            </div>
        <table>
        <tr>
        <td>
        <center><h5>Online</h5></center>
        <iframe frameBorder="0" class="form-control" style="width: 200px;height: 100px;" src="chatterBox/chatroom.php"></iframe>
            </td>
            <td>
            <center><h5>Chats</h5></center>
            <!--<div id="messages" class="form-control" align="left" style="width: 340px;height: 100px;overflow: scroll;"></div>-->
            <iframe class="form-control" style="width: 340px;height: 100px;overflow: scroll;" src="http://192.168.31.166:3000/?course=<?php echo htmlspecialchars($course); ?>"></iframe>
            </td>
            </tr>
        </table>
    <script>
    var socket=io();
    $(() => {
        $("#send").click(()=>{
            var message={course: $("#course").val(),name: $("#name").val(),message: $("#output").val()};
            postMessages(message);
            document.getElementById("output").value = "";
        })
        //getMessages();
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

    /*function getMessages(){
        $.get('http://192.168.31.166:3000/messages',(data)=>{
            data.forEach(addMessages)
        });
    }*/

    function postMessages (message) {
        $.post('http://192.168.31.166:3000/messages',message);
    }
</script>
</div>
</body>
</html>