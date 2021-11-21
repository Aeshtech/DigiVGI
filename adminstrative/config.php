<?php
$host = "localhost";
$username = "root";
$password = "Aeshtech";
$dbname = "digivgi";

$conn = new mysqli($host, $username, $password, $dbname);
if($conn->connect_error){
	die("Failed to connect to MySQL: ".$conn->connect_error);
  }

date_default_timezone_set('Asia/Kolkata'); 
?>