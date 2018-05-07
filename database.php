<?php
$server = 'localhost';
$username = 'root';
$password = '98Saiandravi.';
$database = 'virtual_classroom';

try{
	$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch(PDOException $e){
	die( "Connection failed: " . $e->getMessage());
}
	$cn=mysql_connect("localhost","root","98Saiandravi.") or die("Could not Connect My Sql");
mysql_select_db("virtual_classroom",$cn)  or die("Could connect to Database");
?>