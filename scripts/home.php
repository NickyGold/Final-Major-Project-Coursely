<?php
include "connDB.php";
if (session_status() === PHP_SESSION_NONE){
    session_start();
}
?>
<script>
    document.addEventListener("DOMContentLoaded", () =>{
    updateSidebar("dm");})
</script>
<div id="spacingContainer">
<div id="courseHubContainer">
    <h1>Welcome to Coursely,</h1>
    <p>Search for your course now!</p>
<form id="courseSearchForm">
    <input required type="text" id="searchInput" name="search" placeholder="Search Courses...">
    <button type="submit"><img style="height:100%" src="scripts/data/siteData/searchButton.svg"></button>
</form>
<div id="courseHubList"></div>
</div>
<div id = "accountContainer"></div>
</div>
<script>
    document.getElementById("courseSearchForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const searchValue = document.getElementById("searchInput").value;
        loadCourseHubs(searchValue);
    })
    function getAccountInfo() {
        fetch("scripts/getUser.php")
            .then(response => response.json())
            .then(data => {
                const accountContainer = document.getElementById("accountContainer");
                accountContainer.innerHTML = `
                    <div id = "helloHome"> <p class="accountHome"> Hello </p><img src=${data.ProfilePicture} id = "homePFP"> <p class = "accountHome"> ${data.Username}</p></div>
                `;
            })
            .catch(error => console.error('Error fetching user data:', error));
    }
    getAccountInfo();
</script>