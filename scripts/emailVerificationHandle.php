<?php
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formData = (object) $_POST;
    echo $formData->verificationCode . "-" . $formData->code;
    if($formData->verificationCode == $formData->code){
        echo"the code is correct";
    }
}