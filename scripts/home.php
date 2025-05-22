<?php
include "connDB.php";
if (session_status() === PHP_SESSION_NONE){
    session_start();
}
?>
<form id="courseSearchForm">
    <input type="text" id="searchInput" name="search" placeholder="Search Courses...">
    <button type="submit">Search</button>
</form>
<div id="courseHubList"></div>
<script>
    document.getElementById("courseSearchForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const searchValue = document.getElementById("searchInput").value;
        loadCourseHubs(searchValue);
    })
</script>