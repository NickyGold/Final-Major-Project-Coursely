<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
} include "connDB.php";
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $userID = $_SESSION["userID"];
    $recipientID = $_POST["recipientID"];
    $sql = "INSERT INTO friends (user1, user2, status) VALUES (?,?,?)";
    $arg = $conn->prepare($sql);
    $status = "pending";
    $arg->bind_param("iis", $userID, $recipientID, $status);
    $arg->execute();
}