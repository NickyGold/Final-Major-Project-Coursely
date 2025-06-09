<?php
include "connDB.php";
header('Content-Type: application/json');
$channelID = $_GET['channelID'];
$sql = "SELECT * FROM coursechannels WHERE channelID = ?";
$arg = $conn->prepare($sql);
$arg->bind_param("i", $channelID);
$arg->execute();
$result = $arg->get_result();
$channelInfo = $result->fetch_assoc();
echo json_encode($channelInfo);
?>