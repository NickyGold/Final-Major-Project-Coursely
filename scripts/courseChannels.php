<?php
include "connDB.php";
$courseID = (int) $_GET["courseID"];?>
<div id="messageArea"></div>
<div id="messageInput"></div>
<script>
    document.addEventListener("DOMContentLoaded", ()=> {
        updateSidebar("course", <?= $courseID ?>)
    })
</script>