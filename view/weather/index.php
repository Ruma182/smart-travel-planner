<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Weather Forecast</title>

    <link rel="stylesheet"
          href="/web-technology/smart-travel-planner/style.css">

</head>


<body>


<div class="tool-container">


    <h1>Weather Forecast</h1>


    <p>
        Enter a destination to check weather information.
    </p>


    <input
        type="text"
        id="weatherDestination"
        placeholder="Enter destination"
    >


    <button onclick="getWeather()">
        Check Weather
    </button>


    <div id="weatherResult"></div>


    <a
        href="/web-technology/smart-travel-planner/traveler_dashboard.php"
        class="back-btn"
    >
        ← Back to Dashboard
    </a>


</div>


<script src="/web-technology/smart-travel-planner/js/weather.js"></script>


</body>

</html>