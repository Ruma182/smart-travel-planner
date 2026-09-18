<?php

session_start();

include 'config/database.php';


if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


if ($_SESSION["role"] != "admin") {

    header("Location: login.php");
    exit();

}


if (isset($_GET["id"])) {


    $service_id = (int) $_GET["id"];


    $query = "DELETE FROM services
              WHERE service_id = ?";


    $stmt = mysqli_prepare(
        $conn,
        $query
    );


    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $service_id
    );


    if (mysqli_stmt_execute($stmt)) {

        header(
            "Location: manage_services.php"
        );

        exit();

    }

}


header(
    "Location: manage_services.php"
);

exit();

?>