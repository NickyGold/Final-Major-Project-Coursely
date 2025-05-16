<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
} include "connDB.php";
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $userID = $_SESSION["UserID"];
    $recipientID = $_POST["recipientID"];
    $sql = "UPDATE friends SET status = ? WHERE (user1 = ? AND user2 = ?) AND (user1 = ? AND user2 = ?)";
    $arg = $conn->prepare($sql);
    $arg->bind_param("siiii", 'accepted', $userID, $recipientID, $recipientID, $userID);
    $arg->execute();
}