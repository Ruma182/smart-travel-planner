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

    $review_id = intval($_GET["id"]);
    $traveler_id = $_SESSION["user_id"];

    $query = "
        DELETE FROM reviews
        WHERE review_id = ?
        AND traveler_id = ?
    ";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $review_id,
        $traveler_id
    );

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

header("Location: my_reviews.php");
exit();

?>