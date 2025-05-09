<?php
include "connDB.php";
$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$sql = "SELECT * FROM users WHERE Username = ?";
if ($username == NULL){echo "<a style='Color:Red; font-size:200%;'>Please Enter a Username</a>";
    include "registrationForm.php";
    exit();}
if (strlen($username) < 3 || strlen($name) < 3 || strlen($password) < 3){
    echo "<a style='Color:Red; font-size:200%;'>All fields needs to be at least 3 characters.</a>";
    include "registrationForm.php";
    exit();
}
if ($name == NULL){echo "<a style='Color:Red; font-size:200%;'>Please Enter a Name</a>";
    include "registrationForm.php";
    exit();}
if ($password == NULL){echo "<a style='Color:Red; font-size:200%;'>Please Enter a Password</a>";
    include "registrationForm.php";
    exit();}
$arg = $conn->prepare($sql);
$arg->bind_param("s",$username);
$arg->execute();
$arg = $arg->get_result();
if ($arg->num_rows>0){
    echo "<a style='Color:Red; font-size:200%;'>Username already exists</a>";
    include "registrationForm.php";
    exit();
} else{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sqlins = "INSERT INTO passwords (EncryptedPassword) VALUES (?)";
    $argIns = $conn->prepare($sqlIns);
    $argIns->bind_param("s", $password);
    if ($argIns->execute()){
        $passwordID = $conn->insert_id;
    }
    $sqlIns = "INSERT INTO users (Username, Password, Name, role) VALUES (?,?,?,'USER')";
    $argIns = $conn->prepare($sqlIns);
    $argIns->bind_param("sss", $username,$password,$name);
    $argIns->execute();
    $arg = $conn->prepare($sql);
    $arg->bind_param("s",$username);
    $arg->execute();
    $user = $arg->get_result();
    $user = $user->fetch_assoc();
    $_SESSION["Logged_In"] = true;
    $_SESSION["Name"] = $user["Name"];
    $_SESSION["UserID"] = $user["UserID"];
    header("Location: index.php?file_path=home.php");
    die();
}