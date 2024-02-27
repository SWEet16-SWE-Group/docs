<?php

$server = "mysql";
$username = "root";
$password = "root";
$db = "easymeal";

// Create connection
$conn = new mysqli($server, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>