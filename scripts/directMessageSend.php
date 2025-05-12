<?php
include "connDB.php";
if(session_status() === PHP_SESSION_NONE){
    session_start();
    echo"session started";
}
$participantID = (int) $_GET["participantID"];
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $senderID = $_SESSION["userID"];
    $recipientID = $_POST["recipientID"];
    $message = $_POST["message"];
    $sql = "INSERT INTO messages (senderID, recipientID, message) VALUES (?,?,?)";
    $arg = $conn->prepare($sql);
    $arg->bind_param($senderID, $recipientID, $messageText);
    if ($arg->execute()){
        echo "Message sent!";
    } else {
        echo "Error sending message";
    }
}
?>