<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
    echo"session started";
}
include "connDB.php";
$senderID = (int) $_SESSION["userID"];
$recipientID = (int) $_GET["participantID"];
$sql = "SELECT * FROM users WHERE (userID = ?)";
$arg = $conn->prepare($sql);
$arg->bind_param("i", $senderID);
$arg->execute();
$user1 = $arg->get_result()->fetch_assoc();
$arg = $conn->prepare($sql);
$arg->bind_param("i", $recipientID);
$arg->execute();
$user2 = $arg->get_result()->fetch_assoc();
$sql = "SELECT * FROM directmessages WHERE
        (senderID = ? AND recipientID = ?) OR
        (senderID = ? AND recipientID = ?) ORDER BY
        dateTime ASC";
$arg = $conn->prepare($sql);
$arg->bind_param("iiii" , $senderID, $recipientID, $recipientID, $senderID);
$arg->execute();
$messages = $arg->get_result();
while ($row = $messages->fetch_assoc()){
    if ($row["senderID"] == $user1["UserID"]){
        $activeUser = $user1;
    } else {
        $activeUser = $user2;
    }
    echo "<br><br><br>";
    echo "<img src=" . $activeUser["ProfilePicture"] . " style = 'width:50px; height:50px;'>";
    echo $activeUser["ScreenName"] . "   ----   ";
    echo $row["messageText"];
}
