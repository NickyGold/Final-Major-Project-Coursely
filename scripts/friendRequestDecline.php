<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
} include "connDB.php";
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $userID = $_SESSION["userID"];
    $recipientID = $_POST["recipientID"];
    $sql = "DELETE FROM friends WHERE (user1 = ? AND user2 = ?) OR (user1 = ? AND user2 = ?)";
    $arg = $conn->prepare($sql);
    $arg->bind_param("iiii", $userID, $recipientID, $recipientID, $userID);
    $arg->execute();
}