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


if (isset($_GET["id"])) {


    $event_id = (int) $_GET["id"];

    $explorer_id = $_SESSION["user_id"];


    /*
    শুধু নিজের event delete করতে পারবে
    */

    $query = "DELETE FROM events
              WHERE event_id = ?
              AND explorer_id = ?";


    $stmt = mysqli_prepare(
        $conn,
        $query
    );


    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $event_id,
        $explorer_id
    );


    mysqli_stmt_execute($stmt);

}


header("Location: my_events.php");

exit();

?>