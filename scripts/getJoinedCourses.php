<?php
include "connDB.php";
if (session_status() === PHP_SESSION_NONE){
    session_start();
}
$userID = $_SESSION["userID"];
$sql = "SELECT c.courseName, c.courseDescription FROM coursemembers INNER JOIN courses AS c ON coursemembers.courseID = c.courseID WHERE userID = ?";
$arg = $conn->prepare($sql);
$arg->bind_param("i", $userID);
$arg->execute();
$result = $arg->get_result();
$courses = [];
while ($row = $result->fetch_assoc()){
    $courses[] = $row;
}
echo json_encode($courses);