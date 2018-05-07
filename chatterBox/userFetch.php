<?php
session_start();
$course=$_SESSION['course'];
include_once('config.php');
$result= mysqli_query($conn , "SELECT * FROM student_courses where course_id= '$course'");
while ($row = mysqli_fetch_assoc($result)){
	if($row['login_status'] == 1 ){
		echo "<font color='#009900'>".$row['student_id']."</font><br>";
		}
		else {
				echo "<font color='#FF0000'>".$row['student_id']."</font><br>";
			}
	}

?>