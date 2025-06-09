<?php
header('Content-Type: application/json');
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
include "connDB.php";
$channelID = $_GET["channelID"];
$sql = "SELECT  channelmessages.message,
                channelmessages.timestamp,
                users.UserID,
                users.ScreenName,
                users.ProfilePicture
        FROM channelmessages INNER JOIN users ON channelmessages.userID = users.UserID
        WHERE channelmessages.channelID = ? ORDER BY timestamp DESC";
$arg = $conn->prepare($sql);
$arg->bind_param("i", $channelID);
$arg->execute();
$messages = $arg->get_result();
$chats = [];
if ($messages->num_rows == 0){
    $chats[] = ["UserID" => 4, "message" => "Hi! Be the first to send a message", "ScreenName" => "WelcomeBot", "ProfilePicture" => "scripts/data/profilePictures/waving-hand.png"];
    echo json_encode($chats);
    exit;
}
while ($row = $messages->fetch_assoc()){
    $chats[] = $row;
}
echo json_encode($chats);