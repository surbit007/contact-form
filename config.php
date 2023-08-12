<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "tech_solv";

// Create connection
$conn = mysqli_connect($serverName,$userName,$password,$dbName);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>