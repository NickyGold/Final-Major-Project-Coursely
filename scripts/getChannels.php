<?php
header('Content-Type: application/json');
include "connDB.php";
$courseID = $_GET["courseID"];
$sql = "SELECT * FROM coursechannels WHERE courseID = ?";
$arg = $conn->prepare($sql);
$param = $courseID;
$arg->bind_param("i", $param);
$arg->execute();
$results = $arg->get_result();
$channels = [];
while ($row = $results->fetch_assoc()){
    $channels[] = $row;
}
echo json_encode($channels);