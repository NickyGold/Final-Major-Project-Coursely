<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
include "connDB.php";
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $senderID = $_SESSION["userID"];
    $channelID = (int) $_POST["channelID"];
    $messageText = $_POST["messageInp"];
    $sql = "INSERT INTO channelmessages (userID, channelID, message) VALUES (?,?,?)";
    $arg = $conn->prepare($sql);
    $arg->bind_param("iis", $senderID, $channelID, $messageText);
    $arg->execute();
}