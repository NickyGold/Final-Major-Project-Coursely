<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
    echo"session started";
}
include "connDB.php";
$senderID = (int) $_SESSION["userID"];
$recipientID = (int) $_GET["recipientID"];
$data = file_get_contents("data/keys/DMkeys.JSON");
$keys = json_decode($data,true);
if ($senderID < $recipientID){
    $pointer = $senderID . "-" . $recipientID;
} else {$pointer = $recipientID . "-" . $senderID;}
if(!array_key_exists($pointer, $keys)){
    $key = openssl_random_pseudo_bytes(32);
    $keys[$pointer] = base64_encode($key);
    file_put_contents("data/keys/DMkeys.JSON", json_encode($keys, JSON_PRETTY_PRINT));
} else{$key = base64_decode($keys[$pointer]);}
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
$cipher = "AES-256-CBC";
while ($row = $messages->fetch_assoc()){
    if ($row["senderID"] == $user1["UserID"]){
        $activeUser = $user1;
    } else {
        $activeUser = $user2;
    }
    echo "<br><br><br>";
    echo "<img src=" . $activeUser["ProfilePicture"] . " style = 'width:50px; height:50px;'>";
    echo $activeUser["ScreenName"] . "   ----   ";
    $encrypted = base64_decode($row["messageText"]);
    $iv = substr($encrypted, 0, 16);
    $encrypted = substr($encrypted, 16);
    $decrypted = openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
    echo $decrypted;
}
