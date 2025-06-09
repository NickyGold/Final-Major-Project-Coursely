<?php
include "connDB.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
$sql = "SELECT * FROM users WHERE UserID = ?";
$arg = $conn->prepare($sql);
$arg->bind_param("i", $_SESSION["userID"]);
$arg->execute();
$result = $arg->get_result();
$user = $result->fetch_assoc();
echo json_encode($user);