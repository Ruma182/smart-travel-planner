<?php

session_start();

include 'config/database.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["role"] != "provider") {
    header("Location: login.php");
    exit();
}


if (
    isset($_GET["id"])
    &&
    isset($_GET["status"])
) {

    $booking_id = $_GET["id"];

    $status = $_GET["status"];


    if (
        $status == "Confirmed"
        ||
        $status == "Rejected"
    ) {

        $provider_id = $_SESSION["user_id"];


        $query = "UPDATE bookings

                  SET status = ?

                  WHERE booking_id = ?

                  AND provider_id = ?";


        $stmt = mysqli_prepare(
            $conn,
            $query
        );


        mysqli_stmt_bind_param(
            $stmt,
            "sii",
            $status,
            $booking_id,
            $provider_id
        );


        if (mysqli_stmt_execute($stmt)) {

            header(
                "Location: provider_bookings.php"
            );

            exit();

        }

    }

}


header(
    "Location: provider_bookings.php"
);

exit();

?>