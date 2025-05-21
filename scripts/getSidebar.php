<?php
header('Content-Type: application/json');
include "connDB.php";
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
$userID = $_SESSION["userID"];
$context = $_GET["context"];
$sidebarUsers = [];
if ($context === 'dm'){
    $sql = "SELECT DISTINCT
                CASE
                    WHEN senderID = ? THEN recipientID
                    ELSE senderID
                END otherUser
            FROM directmessages
            WHERE senderID = ? OR recipientID = ?
            ORDER BY dateTime ASC";
    $arg = $conn->prepare($sql);
    $arg->bind_param("iii", $userID, $userID, $userID);
    $arg->execute();
    $result = $arg->get_result();
    while ($row = $result->fetch_assoc()){
        $sql = "SELECT UserID, username, profilePicture FROM users WHERE UserID = ?";
        $arg = $conn->prepare($sql);
        $arg->bind_param("i", $row["otherUser"]);
        $arg->execute();
        $user = $arg->get_result()->fetch_assoc();
        if($user){
            $sidebarUsers[] = $user;
        }
    }
    echo json_encode($sidebarUsers);
    exit;
}
echo json_encode(['error' => 'invalid or unsupported context']);