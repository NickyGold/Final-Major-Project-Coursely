<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
    echo "session started";
}
include "connDB.php";
$username = $_POST['username'];
$password = $_POST['password'];
$sql = "SELECT * FROM users WHERE Username = ?";
if ($username == NULL){echo "<a style='Color:Red; font-size:200%;'>Please Enter a Username</a>";
include "scripts/login.php";
exit();}
$arg = $conn->prepare($sql);
$arg->bind_param("s",$username);
$arg->execute();
$arg = $arg->get_result();
if ($arg->num_rows >0){
    if ($password == NULL){echo "<a style='Color:Red; font-size:200%;'>Please Enter a Password</a>";
        include "scripts/login.php";
        exit();}
    $user = $arg->fetch_assoc();
    $passwordID = $user["PasswordID"];
    $sql = "SELECT * FROM passwords WHERE PasswordID = ?";
    $arg = $conn->prepare($sql);
    $arg->bind_param("i",$passwordID);
    $arg->execute();
    $arg = $arg->get_result();
    if ($arg->num_rows >0){
        $passwordTable = $arg->fetch_assoc();
    if (password_verify($password,$passwordTable["EncryptedPassword"]) == true){
        echo "Access granted";
        $_SESSION["Logged_In"] = true;
        $_SESSION["Name"] = $user["ScreenName"];
        $_SESSION["userID"] = $user["UserID"];
        $_SESSION["Role"] = $user["Role"];
        header("Location: index.php?script=scripts/home.php");
        die();
    }
    else {echo "Invalid Username or Password";
    include "login.php";
    exit();}}
}else{echo "<a style='Color:Red; font-size:200%;'>Invalid Username or Password</a> <br>";
include "login.php";}