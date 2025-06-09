<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function email($recipient, $recipientName, $subject, $body){
    $mail = new PHPMailer(true);
    try{
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'azazel23187@gmail.com';
        $mail->Password = 'uohs redy qves tmzm';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('azazel23187@gmail.com', 'Coursely');
        $mail->addAddress($recipient, $recipientName);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
    } catch (Exception $e){
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}
function imageUpload($targetFolder,$name,$maxByteSize){
    if (isset($_FILES[$name])){
      $targetFile = $targetFolder . basename($_FILES[$name]["name"]);
      $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
      $imageMIMEType = mime_content_type($_FILES[$name]["tmp_name"]);
      $uploadOk = 1;
      $allowedExtensions = ["png","jpg","jpeg","gif"];
      $allowedMIMEExtensions = ["image/png","image/jpeg","image/gif"];
      $check = getimagesize($_FILES[$name]["tmp_name"]);
      if ($check !== false){
          $uploadOk = 1;
      } else{
          $uploadOk = 0;
      }
      $a = 1;
      $checkstring = $targetFile;
      if(file_exists($checkstring)){
      while (file_exists($checkstring)){
          $checkstring = $targetFile;
          $checkstring = substr_replace($targetFile, $a, -5,1);
          $a +=1;
      } $targetFile = $checkstring;}
      if ($_FILES[$name]["size"] > $maxByteSize){
          echo "Sorry only files up to " . $maxByteSize / 1024 / 1024 . " Megabytes allowed.";
          $uploadOk = 0;
      }
      if (!in_array($imageFileType, $allowedExtensions)){
          echo "JPG, JPEG, PNG, & GIF files only.";
          $uploadOk = 0;
      }
      if (!in_array($imageMIMEType, $allowedMIMEExtensions)){
        echo "MIME Type is not a JPEG, PNG, or GIF.";
        $uploadOk = 0;
      }
      if ($uploadOk == 0) {
          echo "Your file was not uploaded.";
          $targetFile = "NULL";
        } else {
          if (move_uploaded_file($_FILES[$name]["tmp_name"], $targetFile)) {
          } else {
            echo "There was an error uploading your file.";
            $targetFile = "NULL";
          }
        }
      return $targetFile;
  }}