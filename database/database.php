<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "spotify";

$conn = new mysqli($host, $username, $password, $dbname);

if(!$conn = mysqli_connect($host, $username, $password, $dbname))
{
    die("connection failed!" .$conn->connect_error);
}
// echo"Connected";
?>