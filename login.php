<?php

session_start();

if( isset($_SESSION['user_id']) ){
	session_unset();
	session_destroy();
	header("Location: /project/login.php");
}

require 'database.php';

if(!empty($_POST['email']) && !empty($_POST['password'])):
	if ($_POST['category']=='Student'):
	
	$records = $conn->prepare('SELECT username,password FROM student WHERE username = :email');
	else:
		$records = $conn->prepare('SELECT username,password FROM staff WHERE username = :email');
	endif;

	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){

		$_SESSION['user_id'] =$_POST['email']; //$results['id'];
		$_SESSION['category']=$_POST['category'];
		$_SESSION['course']=$_POST['course'];
		$user=$_POST['email'];
		$course=$_POST['course'];
		if ($_POST['category']=='Student'):
			$conn->query("UPDATE student_courses set login_status=1 where student_id= '$user' and course_id= '$course'");
		else:
			$conn->query("UPDATE faculty_courses set login_status=1 where faculty_id= '$user' and course_id= '$course'");
		endif;
		echo '<meta http-equiv="refresh" content="0; url=classroom1.php">';
		//header("Location: classroom.php/");

	} else {
		$message = 'Sorry, those credentials do not match';
	}

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
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
			<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
			</ul>
		</div>
	</nav>


	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Login</h1>

	<form action="login.php" method="POST">
		
		<input type="text" placeholder="Enter your email" name="email">
		<input type="password" placeholder="Enter your password" name="password">
		<center><select name="category">
		<option value="" disabled selected>Category</option>
  			<option value="Student">Student</option>
		  	<option value="Professor">Professor</option>
		</select></center><br>
		<center><select name="course">
			<option value="" disabled selected>Course</option>
  			<option value="dbms">DBMS</option>
		</select></center><br>
		<input type="submit" value="Login">

	</form>
	<span>No account? <a href="register.php">Register here</a></span>
</body>
</html>