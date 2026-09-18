
<?php

session_start();

include 'config/database.php';


// ==============================
// LOGIN CHECK
// ==============================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


// ==============================
// TRAVELER CHECK
// ==============================

if ($_SESSION["role"] != "traveler") {

    header("Location: login.php");
    exit();

}


// ==============================
// GET USER ID
// ==============================

$user_id = $_SESSION["user_id"];


// ==============================
// GET DESTINATION NAME
// ==============================

if (!isset($_GET["destination"])) {

    header("Location: destinations.php");
    exit();

}


$destination_name = trim($_GET["destination"]);


// ==============================
// CHECK IF ALREADY SAVED
// ==============================

$check_query = "
    SELECT favorite_id
    FROM favorites
    WHERE user_id = ?
    AND destination_name = ?
";


$check_stmt = mysqli_prepare(
    $conn,
    $check_query
);


mysqli_stmt_bind_param(
    $check_stmt,
    "is",
    $user_id,
    $destination_name
);


mysqli_stmt_execute($check_stmt);


$check_result = mysqli_stmt_get_result(
    $check_stmt
);


// ==============================
// IF ALREADY EXISTS
// ==============================

if (mysqli_num_rows($check_result) > 0) {

    header("Location: my_favorites.php");
    exit();

}


// ==============================
// SAVE FAVORITE
// ==============================

$insert_query = "
    INSERT INTO favorites
    (
        user_id,
        destination_name
    )
    VALUES (?, ?)
";


$insert_stmt = mysqli_prepare(
    $conn,
    $insert_query
);


mysqli_stmt_bind_param(
    $insert_stmt,
    "is",
    $user_id,
    $destination_name
);


mysqli_stmt_execute($insert_stmt);


// ==============================
// REDIRECT
// ==============================

header("Location: my_favorites.php");

exit();

?>

