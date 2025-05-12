<?php
include "functions.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    $filePath = imageUpload("data/tmp/", "profilePicture", 100000000000);

    $formData = (object) $_POST;
    $verificationCode = substr(bin2hex(random_bytes(3)), 0, 6);
    email(
        $formData->email,
        $formData->name,
        "Coursely verification code",
        "Hi " . $formData->name . " your verification code is " . $verificationCode);
    ?>
    <form action = "emailVerificationHandle.php" method = "post">
        <label for="code"> An email was sent to you with a verification code please input it, </label>
        <input type = "text" name="code" id="code" required><br>
        <input type="hidden" name="username" value="<?= htmlspecialchars($formData->username) ?>">
        <input type="hidden" name="name" value="<?= htmlspecialchars($formData->name) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($formData->email) ?>">
        <input type="hidden" name="password" value="<?= htmlspecialchars($formData->password) ?>">
        <input type="hidden" name="description" value="<?= htmlspecialchars($formData->description) ?>">
        <input type="hidden" name="verificationCode" value="<?= $verificationCode ?>">
        <input type="hidden" name="profilePicture" value="<?= $filePath ?>">
        <input type="submit" value="verify">
    </form>
<?php
}