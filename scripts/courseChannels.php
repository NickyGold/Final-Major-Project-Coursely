<?php
include "connDB.php";
$courseID = (int) $_GET["courseID"];?>
<div id = "courseMessages">
<div id="chatMessages"></div>
<form id="chatForm"></form>
</div>
<script>
    document.addEventListener("DOMContentLoaded", ()=> {
        updateSidebar("course", <?= $courseID ?>)
    })
</script>