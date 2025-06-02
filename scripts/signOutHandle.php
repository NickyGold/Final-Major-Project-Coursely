<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
$_SESSION["Logged_In"] = false;
$_SESSION["Name"] = NULL;
$_SESSION["userID"] = NULL;
$_SESSION["Role"] = NULL;
header("Location: index.php?script=scripts/home.php");
die();