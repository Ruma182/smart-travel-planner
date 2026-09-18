<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["role"] != "traveler") {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Weather Forecast</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="tool-container">

        <h1>Weather Forecast</h1>

        <p>Enter a destination to check weather information.</p>

        <input
            type="text"
            id="weatherDestination"
            placeholder="Enter destination"
        >

        <button onclick="getWeather()">
            Check Weather
        </button>

        <div id="weatherResult"></div>

        <a href="traveler_dashboard.php" class="back-btn">
            ← Back to Dashboard
        </a>

    </div>

    <script src="js/weather.js"></script>

</body>

</html>