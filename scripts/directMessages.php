<?php
include "connDB.php"; ?>
<script>
    document.addEventListener("DOMContentLoaded", () =>{
    updateSidebar("dm");})
</script><?php
if($_GET["recipientID"] == NULL){
} else {
    $recipientID = $_GET["recipientID"];
    $sql = "SELECT * FROM users WHERE UserID = ?";
    $arg = $conn->prepare($sql);
    $arg->bind_param("i", $recipientID);
    $arg->execute();
    $recipient = $arg->get_result()->fetch_assoc();
?>
<div id='DM'>
<form id="chatForm">
    <input type="hidden" name="recipientID" value=<?= $recipientID ?>>
    <input required type="text" name = "messageInp" id="messageInp" placeholder='Message @<?=$recipient["Username"]?>'>
    <button class = 'DMButton' type="submit"><img src="scripts/data/siteData/Send-Button.svg" class = 'sendButton'></button>
</form>
<div id="chatMessages"></div>
</div><?php } ?>
<script>
    document.getElementById('chatForm').addEventListener('submit', function(e){
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    fetch('scripts/directMessagesSend.php', {
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
        fetch('scripts/directMessagesRead.php?recipientID= <?= $recipientID?>')
        .then(res => res.text())
        .then(data=> {
            document.getElementById('chatMessages').innerHTML = data;
        })
    }
    loadMessages();
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
</script>