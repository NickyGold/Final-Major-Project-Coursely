<?php
include "connDB.php";
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
$userID = $_SESSION["userID"];
$courseID = $_POST["courseID"];
$sql = "SELECT * FROM coursemembers WHERE userID = ? AND courseID = ?";
$arg = $conn->prepare($sql);
$arg->bind_param("ii", $userID, $courseID);
$arg->execute();
$result = $arg->get_result();
if($result->num_rows > 0){
    exit;
}
$sql = "INSERT INTO coursemembers (userID, courseID) VALUES (?,?)";
$arg = $conn->prepare($sql);
$arg->bind_param("ii", $userID, $courseID);
$arg->execute();
echo "joined!";