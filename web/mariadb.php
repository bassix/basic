<?php

$servername = "127.0.0.1";
$username = "basic";
$password = "Qy184Zloj6Jt";
$database = "basic";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to MariaDB";

$conn->close();
