<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    include "connDB.php";
    $formData = (object) $_POST;
    echo $formData->verificationCode . "-" . $formData->code;
    if($formData->verificationCode == $formData->code){
        $newDir = "scripts/data/profilePictures/";
        $baseName = basename($formData->profilePicture);
        $newPath = $newDir . $baseName;
        $checkstring = $newPath;
        $counter = 0;
        if(file_exists($checkstring)){
            while (file_exists($checkstring)){
                $checkstring = $newPath;
                $checkstring = substr_replace($newPath, $counter, -5,1);
                $counter +=1;
        } $newPath = $checkstring;}
        rename($formData->profilePicture, $newPath);
        $sqlPass = "INSERT INTO passwords (EncryptedPassword) VALUES (?)";
        $password = password_hash($formData->password, PASSWORD_DEFAULT);
        $argPass = $conn->prepare($sqlPass);
        $argPass->bind_param("s",$password);
        if($argPass->execute()){
            $passID = $conn->insert_id;
        }
        $sql = "INSERT INTO users (Email, Username, ScreenName, Description, PasswordID, RateLimit, ProfilePicture, Role) VALUES (?,?,?,?,?,?,?,?)";
        $arg = $conn->prepare($sql);
        $role = "USER";
        $email = $formData->email;
        $username = $formData->username;
        $name = $formData->name;
        $description = $formData->description;
        $rateLimit = 0;
        $profilePicture = $newPath;
        $role = "USER";
        $arg->bind_param(
            "ssssiiss",
            $email,
            $username,
            $name,
            $description,
            $passID,
            $rateLimit,
            $profilePicture,
            $role
        );
        if($arg->execute()){
            echo "account made";
            $_SESSION["Logged_In"] = true;
            $_SESSION["userID"] = $conn->insert_id;
            $_SESSION["Name"] = $name;
            $_SESSION["Role"] = $role;
            header("Location = index.php?script=scripts/home.php");
            die();
        }
    }
    else{
        echo"Incorrect a new email has been sent.";
        include "emailVerification.php";
    }
}