<div id = "logIncontainer">
<form id = "logInForm" action="index.php?script=scripts/loginHandle.php" method="post">
    <label for="username-inp">Username:</label>
    <input type="text" id = "username-inp" name="username" placeholder="Username...">
    <label for="password-inp">Password:</label>
    <input type="password" id = "password-inp" placeholder="Password..." name="password">
    <button type="submit" id = "loginButton">Log In</button>
    <p id = "registerCTA">Don't have an account? <br><button type="button" id = "registerCTAButton"> <a href = "index.php?script=scripts/registrationform.php"> Register Here! </a></button></p>
</form>
</div>