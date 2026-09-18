<?php

session_start();

include 'config/database.php';

if (
    !isset($_SESSION["user_id"]) ||
    $_SESSION["role"] != "admin"
) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["booking_id"])) {
    header("Location: admin_bookings.php");
    exit();
}

$booking_id = intval($_GET["booking_id"]);

$query = "
    UPDATE bookings
    SET status = 'rejected'
    WHERE booking_id = ?
      AND status = 'pending'
";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $booking_id
);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

header("Location: admin_bookings.php");
exit();

?>