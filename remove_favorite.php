<?php

session_start();

include 'config/database.php';


if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


if ($_SESSION["role"] != "traveler") {

    header("Location: login.php");
    exit();

}


if (isset($_GET["id"])) {

    $favorite_id = $_GET["id"];

    $user_id = $_SESSION["user_id"];


    $query = "DELETE FROM favorites

              WHERE favorite_id = ?

              AND user_id = ?";


    $stmt = mysqli_prepare(
        $conn,
        $query
    );


    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $favorite_id,
        $user_id
    );


    mysqli_stmt_execute($stmt);

}


header(
    "Location: my_favorites.php"
);

exit();

?>