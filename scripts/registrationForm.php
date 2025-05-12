<form id="registration" action="emailVerification.php" method="post" enctype="multipart/form-data">
    <label for="username-inp"> Please enter a username: (This cannot be changed)</label>
    <input type="text" id = "username-inp" name="username"><br>
    <label for="name-inp">Please enter your screen name:</label>
    <input type="text" id = "name-inp" name="name"><br>
    <label for="email-inp">Please enter your E-mail:</label>
    <input type="text" id = "email-inp" name="email"><br>
    <label for="password-inp"> Please enter a password: </label>
    <input type="text" id = "password-inp" name="password"><br>
    <label for="description-inp"> Please enter a description for your profile: </label>
    <input type="text" id = "description-inp" name="description"><br>
    <label for="profilepicture-inp"> Please input a profile picture: </label>
    <input type="file" id = "profilepicture-inp" name="profilePicture" accept="image/jpeg, image/png, image/gif, image/jpg"><br>
    <input type="submit" value="Submit">
</form>