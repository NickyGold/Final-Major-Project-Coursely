<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Coursely</title>
    <link rel="stylesheet" href ="scripts/css/styles.css">
<body>
    <?php include $_GET["script"];?>
<div id= "userPopup"class="userPopup"></div>
<div id = "sidebar">
</div>

</body>
<script>
    function showUserPopup(userID) {
        fetch(`scripts/getUserPopup.php?userID=${userID}`)
        .then(res => res.text())
        .then(html => {
            const popup = document.getElementById("userPopup");
            popup.innerHTML = `<div class="userPopupContent">${html}</div>`;
            popup.classList.add('active');
        });
    }
    function closeUserPopup() {
        const popup = document.getElementById("userPopup");
        popup.innerHTML = "";
        popup.classList.remove('active');
    }
    function sendFriendRequest(recipientID) {
        const formData = new FormData();
        formData.append("recipientID", recipientID);
        fetch("scripts/friendRequestSend.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(response => {
        })
        showUserPopup(recipientID);
    }
    function acceptFriendRequest(recipientID){
        const formData = new FormData();
        formData.append("recipientID", recipientID);
        fetch("scripts/friendRequestAccept.php", {
            method: "POST",
            body: formData
        })
        showUserPopup(recipientID);
    }
    function declineFriendRequest(recipientID){
        const formData = new FormData();
        formData.append("recipientID", recipientID);
        fetch("scripts/friendRequestDecline.php", {
            method: "POST",
            body: formData
        })
        showUserPopup(recipientID);
    }
    function startDirectMessage(recipientID){
        window.location.href = "index.php?script=scripts/directMessages.php&recipientID=" + recipientID;
    }
    async function updateSidebar(context){
        const sidebar = document.getElementById("sidebar");
        sidebar.innerHTML = "LOADING...";
        const res = await fetch(`scripts/getSidebar.php?context=${context}`);
        const users = await res.json();
        sidebar.innerHTML = "";
        if (context == "dm"){
        users.forEach(user => {
            const div = document.createElement("div");
            div.className = "sidebarItem";
            const img = document.createElement("img");
            img.src = user.profilePicture;
            img.alt = user.username;
            img.className = "sidebarAvatar";
            const name = document.createElement("span");
            name.textContent = user.username;
            div.appendChild(img);
            div.appendChild(name);
            div.addEventListener("click", () => {
                startDirectMessage(user.UserID);
            });
            sidebar.appendChild(div);
        })}
    }
    async function loadChannels(courseID){
        const res = await fetch(`scripts/getChannels.php?courseID=${courseID}`)
    }
</script>
</html>
