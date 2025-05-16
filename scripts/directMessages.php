<?php
include "connDB.php";
if($_GET["recipientID"] == NULL){
    echo "DM selection coming soon";
    die();
} else {
    $recipientID = $_GET["recipientID"];
    $sql = "SELECT * FROM users WHERE UserID = ?";
    $arg = $conn->prepare($sql);
    $arg->bind_param("i", $recipientID);
    $arg->execute();
    $recipient = $arg->get_result()->fetch_assoc();
}?>
<form id="chatForm">
    <input type="hidden" name="recipientID" value=<?= $recipientID ?>>
    <textarea type="message" name = "messageInp" id="messageInp" placeholder='Message @<?=$recipient["ScreenName"]?>'></textarea>
    <button type="submit">Send</button>
</form>
<div id="chatMessages"></div>
<script>
    document.getElementById('chatForm').addEventListener('submit', function(e){
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    fetch('directMessagesSend.php', {
        method:'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        console.log(data);
        form.reset();
        loadMessages();
    });
    });
    function loadMessages(){
        fetch('directMessagesRead.php?recipientID= <?= $recipientID?>')
        .then(res => res.text())
        .then(data=> {
            document.getElementById('chatMessages').innerHTML = data;
        })
    }
    loadMessages();
    setInterval(loadMessages,1000);
</script>