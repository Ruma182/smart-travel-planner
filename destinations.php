<?php

session_start();


// ========================================
// LOGIN CHECK
// ========================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Explore Destinations - Smart Travel Planner
    </title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>


<body>


<div class="destination-page">


    <h1>
        Explore Destinations
    </h1>


    <p>
        Search and discover amazing places
        for your next journey.
    </p>


    <input
        type="text"
        id="searchInput"
        placeholder="Search destination..."
        autocomplete="off"
    >


    <div id="destinationResults"></div>


    <a
        href="traveler_dashboard.php"
        class="back-btn"
    >
        ← Back to Dashboard
    </a>


</div>

<script src="js/search.js"></script>

<script>
    console.log("DESTINATION PAGE LOADED");
</script>


</body>

</html>