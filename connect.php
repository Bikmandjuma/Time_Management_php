<?php
$conn=new mysqli("localhost","root","","timemanagementdb");
if (!$conn) {
	die("Db not connect".mysqli_error($conn));
}
?>