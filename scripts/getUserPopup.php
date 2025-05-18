<?php
include "connDB.php";
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
$userID = (int) $_GET["userID"];
$selfID = (int) $_SESSION["userID"];
$sql = "SELECT Username, ScreenName, Description, ProfilePicture FROM users WHERE UserID = ?";
$arg = $conn->prepare($sql);
$arg->bind_param("i", $userID);
$arg->execute();
$result = $arg->get_result();
if($result->num_rows === 0){
    echo "User not found.";
    exit;
}
$sqlFriend = "SELECT * FROM friends WHERE (user1=? AND user2=?) OR (user1=? AND user2=?)";
$argFriend = $conn->prepare($sqlFriend);
$argFriend->bind_param("iiii",$selfID, $userID, $userID, $selfID);
$argFriend->execute();
$resultFriend = $argFriend->get_result();
if ($resultFriend->num_rows == 0){
    $friendStatus = "NULL";
} else{
    $friendStatus = $resultFriend->fetch_assoc();
}
$user = $result->fetch_assoc();
?>
<div class="userPopup">
    <h3><?= htmlspecialchars($user["ScreenName"]) ?></h3>
    <p>@<?= htmlspecialchars($user["Username"]) ?></p>
    <p><?= htmlspecialchars($user["Description"]) ?></p>
    <?php if ($userID == $selfID){ echo "This is You!";}else{ if ($friendStatus === "NULL"){
    echo "<button onclick='sendFriendRequest($userID)'>Send Friend Request</button>";}
    else{
        if ($friendStatus["status"] == "pending" && $friendStatus["user1"] == $selfID){
            echo"Friend Request Pending";
        }
        if ($friendStatus["status"] == "pending" && $friendStatus["user2"] == $selfID){
            echo "<button onclick='acceptFriendRequest($userID)'>Accept Friend Request</button>";
            echo "<button onclick='declineFriendRequest($userID)'>Decline Friend Request</button>";
        }
        if ($friendStatus["status"] == "accepted"){
            echo"Friends!";
        }
    }
    echo "<button onclick='startDirectMessage($userID)'>Direct Message </button>";}?>
    <br><button onclick="closeUserPopup()">Close</button>
</div>