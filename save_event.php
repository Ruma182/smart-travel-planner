<?php

session_start();

include 'config/database.php';


if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


if ($_SESSION["role"] != "local_explorer") {

    header("Location: login.php");
    exit();

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $explorer_id = $_SESSION["user_id"];

    $event_name = trim($_POST["event_name"]);

    $location = trim($_POST["location"]);

    $event_date = $_POST["event_date"];

    $description = trim($_POST["description"]);


    $query = "INSERT INTO events
    (
        explorer_id,
        event_name,
        location,
        event_date,
        description
    )
    VALUES (?, ?, ?, ?, ?)";


    $stmt = mysqli_prepare(
        $conn,
        $query
    );


    mysqli_stmt_bind_param(
        $stmt,
        "issss",
        $explorer_id,
        $event_name,
        $location,
        $event_date,
        $description
    );


    if (mysqli_stmt_execute($stmt)) {


        echo "
        <script>

            alert('Event added successfully!');

            window.location.href =
                'my_events.php';

        </script>
        ";


    } else {


        echo "
        <script>

            alert('Failed to add event!');

            window.location.href =
                'add_event.php';

        </script>
        ";

    }

}


?>