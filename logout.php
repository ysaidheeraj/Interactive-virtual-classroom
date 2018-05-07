<?php

require 'database.php';

session_start();
if (isset($_SESSION['user_id'])){
    $user=$_SESSION['user_id'];
    $course=$_SESSION['course'];
    if ($_SESSION['category']=='Student'){
        $conn->query("UPDATE student_courses set login_status=0 where student_id= '$user' and course_id= '$course'");
    }
    else{
        $conn->query("UPDATE faculty_courses set login_status=0 where faculty_id= '$user' and course_id= '$course'");
    }
}
session_unset();

session_destroy();

echo '<meta http-equiv="refresh" content="0; url=index.php">';