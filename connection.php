<?php
//$con=mysqli_connect('localhost', 'root', '', 'test_db') or die("Failed to connect: ". mysqli_error($con));

$dbms="mysql";
$host="localhost";
$db="test_db";
$user="root";
$pass="";
$dsn="$dbms:host=$host;dbname=$db";
$con=new PDO($dsn, $user, $pass);
