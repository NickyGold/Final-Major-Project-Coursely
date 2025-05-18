<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
} include "connDB.php";
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $userID = $_SESSION["userID"];
    $recipientID = $_POST["recipientID"];
    $sql = "UPDATE friends SET status = ? WHERE (user1 = ? AND user2 = ?) OR (user1 = ? AND user2 = ?)";
    $arg = $conn->prepare($sql);
    $status = 'accepted';
    $arg->bind_param("siiii", $status, $userID, $recipientID, $recipientID, $userID);
    $arg->execute();
}