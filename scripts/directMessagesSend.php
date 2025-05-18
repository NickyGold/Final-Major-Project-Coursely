<?php
include "connDB.php";
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
$recipientID = (int) $_POST["recipientID"];
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $senderID = $_SESSION["userID"];
    $recipientID = $_POST["recipientID"];
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
    $messageText = $_POST["messageInp"];
    $cipher = "AES-256-CBC";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $cipherText = openssl_encrypt($messageText, $cipher, $key, 0, $iv);
    $payload = base64_encode($iv . $cipherText);
    $sql = "INSERT INTO directmessages (senderID, recipientID, messageText) VALUES (?,?,?)";
    $arg = $conn->prepare($sql);
    $arg->bind_param("iis",$senderID, $recipientID, $payload);
    if ($arg->execute()){
        echo "Message sent!";
    } else {
        echo "Error sending message";
    }
}