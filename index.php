<!DOCTYPE html>
<body>
<?php include $_GET["script"];?>
<div id= "userPopup" style="display:none"></div>
<div onclick="showUserPopup(1)">
  @test
</div>

</body>
<script>
    function showUserPopup(userID) {
        fetch(`scripts/getUserPopup.php?userID=${userID}`)
        .then(res => res.text())
        .then(html => {
            const popup = document.getElementById("userPopup");
            popup.innerHTML = html;
            popup.style.display = "block";
        });
    }
    function closeUserPopup() {
        const popup = document.getElementById("userPopup");
        popup.innerHTML = "";
        popup.style.display = "none";
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
</script>
</html>