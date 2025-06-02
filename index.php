<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
if($_SESSION["Logged_In"] == false){
    include "scripts/login.php";
    exit;
} else{
?><div id="content"><?php include $_GET["script"];?> </div><?php } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Coursely</title>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href ="scripts/css/styles.css">
<body>
<div id= "userPopup"class="userPopup"></div>
<div id = "sidebar"></div>
<div id = "courseHomeAndDMArea">
    <div id = "homeAndDMArea">
        <a href="index.php?script=scripts/home.php" class="courseSidebarHome"><img style = "height:100%; width:100%; object-fit:contain;" src = "scripts\data\siteData\Home.svg"></a>
        <a href="index.php?script=scripts/directMessages.php" class = "courseSidebarDM"> <img style = "height:100%; width:100%;object-fit:contain;" src = "scripts\data\siteData\DMs.svg"></a>
    </div>
    <div id = "courseArea"></div>
    <div id="signOutArea">
        <a href="index.php?script=scripts/signOutHandle.php" class="courseSidebarSignOut"><img style = " height:95%; margin-left:5px; object-fit:contain;" src = "scripts\data\siteData\Log-Out.svg"></a>
    </div>
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
    async function updateSidebar(context, courseID = ""){
        const sidebar = document.getElementById("sidebar");
        sidebar.innerHTML = "LOADING...";
        if (context == "dm"){
        const res = await fetch(`scripts/getSidebar.php?context=${context}`);
        const users = await res.json();
        sidebar.innerHTML = "";
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
            div.onclick = () => startDirectMessage(user.UserID);
            sidebar.appendChild(div);
        })}
        if (context=="course"){
            const res = await fetch(`scripts/getChannels.php?courseID=${courseID}`);
            const channels = await res.json();
            sidebar.innerHTML = "";
            channels.forEach(channel => {
                const div = document.createElement("div");
                div.className = "sidebarItem";
                div.textContent = channel.channelName;
                div.onclick = () => {
                                    loadChannelMessages(channel.channelID);
                                    loadMessageInput(channel.channelID);
                                };
                sidebar.appendChild(div);
            })
        }
    }
    async function loadCourseHubs(search = '') {
        const res = await fetch(`scripts/getCourseHubs.php?search=${encodeURIComponent(search)}`);
        const hubs = await res.json();
        const container = document.getElementById("courseHubList");
        container.innerHTML = "";
        hubs.forEach(hub => {
            const div = document.createElement("div");
            div.className = "hubItem";
            div.innerHTML = `
            <h3>${hub.courseName}</h3>
            <p>${hub.courseDescription}</p>
            <button onclick="joinCourse(${hub.courseID})">Join</button>`;
        container.appendChild(div);
        });
    }
function joinCourse(courseID) {
    const formData = new FormData();
    formData.append("courseID", courseID);
    fetch("scripts/joinCourseHub.php", {
        method: "POST",
        body: formData
    }).then(res => res.text())
    .then(data => {
        alert("Joined hub!")
        window.location.href = "index.php?script=scripts/courseChannels.php&courseID=" + courseID;
    });
}
async function loadChannelMessages(channelID) {
    const res = await fetch(`scripts/getMessages.php?channelID=${channelID}`);
    const messages = await res.json();
    const messageArea = document.getElementById("messageArea");
    messageArea.innerHTML = "";
    messages.forEach(msg => {
        const div = document.createElement("div");
        div.className = "messageContainer";
        const img = document.createElement("img");
        img.src = msg.ProfilePicture;
        img.alt = msg.ScreenName;
        img.className = "messageUserAvatar";
        img.onclick = () => {
            showUserPopup(msg.UserID);
        }
        const name = document.createElement("span");
        name.className = "messageUserName";
        name.textContent = msg.ScreenName;
        const message = document.createElement("span");
        message.className = "message";
        message.textContent = msg.message;
        div.appendChild(img);
        div.appendChild(name);
        div.appendChild(message);
        messageArea.appendChild(div);
    })
}
async function loadMessageInput(channelID) {
    const div = document.getElementById('messageInput');
    div.innerHTML = "";
    const form = document.createElement("form");
    form.id = "chatInput";
    form.method = "POST";
    const hiddeninp = document.createElement("input");
    hiddeninp.type = "hidden";
    hiddeninp.name = "channelID";
    hiddeninp.value = channelID;
    form.appendChild(hiddeninp);
    const messageinp = document.createElement("input");
    messageinp.type = "text";
    messageinp.name = "messageInp";
    form.appendChild(messageinp);
    const button = document.createElement("button");
    button.type = "submit";
    button.textContent = "Submit";
    form.appendChild(button);
    form.addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        fetch("scripts/sendMessages.php", {
            method: "POST",
            body: formData
        }).then(res => res.text())
        .then(data=> {console.log("Debug: ", data);
        messageinp.value = "";
        loadChannelMessages(channelID);
    })
    });
    div.appendChild(form);
}
async function loadJoinedCourses(){
    const res = await fetch("scripts/getJoinedCourses.php");
    const courses = await res.json();
    const courseArea = document.getElementById("courseArea");
    courses.forEach(course => {
        const div = document.createElement("div");
        div.onclick = () => {
            window.location.href = "index.php?script=scripts/courseChannels.php&courseID=" + course.courseID;
        }
        div.className = "courseSidebarItem";
        const courseName = document.createElement("span");
        courseName.textContent = course.courseName;
        courseName.className = "courseSidebarName";
        const courseDesc = document.createElement("span");
        courseDesc.textContent = course.courseDescription;
        courseDesc.className = "courseSidebarDesc";
        div.appendChild(courseName);
        div.appendChild(courseDesc);
        courseArea.appendChild(div);
    });
}
loadJoinedCourses();
</script>
</html>
