<?php

session_start();


if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


if ($_SESSION["role"] != "local_explorer") {

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

    <title>Add Local Event</title>

    <link rel="stylesheet" href="style.css">

</head>


<body>


<div class="booking-container">


    <h1>Add Local Event</h1>

    <p>
        Add a local festival, fair, cultural program or other event.
    </p>


    <form action="save_event.php" method="POST">


        <input
            type="text"
            name="event_name"
            placeholder="Event Name"
            required
        >


        <input
            type="text"
            name="location"
            placeholder="Event Location"
            required
        >


        <label>Event Date</label>

        <input
            type="date"
            name="event_date"
            required
        >


        <textarea
            name="description"
            placeholder="Event Description"
            required
        ></textarea>


        <button type="submit">
            Add Event
        </button>


    </form>


    <a
        href="local_explorer_dashboard.php"
        class="back-btn"
    >

        ← Back to Dashboard

    </a>


</div>


</body>

</html>