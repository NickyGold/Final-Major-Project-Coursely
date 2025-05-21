<?php
header('Content-Type: application/json');
include "connDB.php";
$search = $_GET["search"];
$sql = "SELECT * FROM courses WHERE courseName LIKE ?";
$arg = $conn->prepare($sql);
$param = "%$search%";
$arg->bind_param("s", $param);
$arg->execute();
$results = $arg->get_result();
$courses = [];
while ($row = $result->fetch_assoc()){
    $courses[] = $row;
}
echo json_encode($courses);