<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecor"; 
$port="3306";
 // Updated database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname,$port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
