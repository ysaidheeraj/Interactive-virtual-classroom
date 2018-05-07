<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

require 'database.php';

$message = '';

if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['first_name']) && !empty($_POST['last_name'])):
		if($_POST['category']=='Student'):
	
	// Enter the new user in the database
	$sql = "INSERT INTO student (student_id,first_name,last_name,username, password) VALUES (:student_id,:first_name,:last_name,:username, :password)";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':student_id', $_POST['student_id']);
	$stmt->bindParam(':first_name', $_POST['first_name']);
	$stmt->bindParam(':last_name', $_POST['last_name']);
	$stmt->bindParam(':username', $_POST['username']);
	$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

	if( $stmt->execute() ):
		$message = 'Successfully created new user';
	else:
		$message = 'Sorry there must have been an issue creating your account';
	endif;
endif;
	if($_POST['category']=='Professor'):
	
	// Enter the new user in the database
	$sql = "INSERT INTO staff (first_name,last_name,username, password) VALUES (:first_name,:last_name,:username, :password)";
	$stmt = $conn->prepare($sql);

	//$stmt->bindParam(':student_id', $_POST['student_id']);
	$stmt->bindParam(':first_name', $_POST['first_name']);
	$stmt->bindParam(':last_name', $_POST['last_name']);
	$stmt->bindParam(':username', $_POST['username']);
	$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

	if( $stmt->execute() ):
		$message = 'Successfully created new user';
	else:
		$message = 'Sorry there must have been an issue creating your account';
	endif;
endif;

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register Below</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href="/">Virtual Interactive Classroom</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Register</h1>
	<span>or <a href="login.php">login here</a></span>

	<form action="register.php" method="POST">
		<input type="text" placeholder="Enter your Student ID" name="student_id">
		<input type="text" placeholder="Enter your First name" name="first_name">
		<input type="text" placeholder="Enter your Last name" name="last_name">
		<input type="text" placeholder="Enter your email" name="username">
		<input type="password" placeholder="and password" name="password">
		<input type="password" placeholder="confirm password" name="confirm_password">
		<select name="category">
  			<option value="Student">Student</option>
		  	<option value="Professor">Professor</option>
		</select> 
		<input type="submit" value="Register">

	</form>

</body>
</html>