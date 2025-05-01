<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fmp-coursely";

$conn = new mysqli(hostname:$servername, username: $username,password: $password,database: $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected!";