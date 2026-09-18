<?php

session_start();

include 'config/database.php';


/* =========================
   LOGIN CHECK
========================= */

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


/* =========================
   TRAVELER CHECK
========================= */

if ($_SESSION["role"] != "traveler") {

    header("Location: login.php");
    exit();

}


/* =========================
   POST CHECK
========================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $traveler_id = $_SESSION["user_id"];

    $destination_id = intval(
        $_POST["destination_id"]
    );

    $service_id = intval(
        $_POST["service_id"]
    );

    $rating = intval(
        $_POST["rating"]
    );

    $review_text = trim(
        $_POST["review_text"]
    );


    /* =========================
       VALIDATION
    ========================= */

    if (
        $destination_id <= 0 ||
        $service_id <= 0 ||
        $rating < 1 ||
        $rating > 5 ||
        empty($review_text)
    ) {

        die(
            "Please provide a valid destination, service, rating and review."
        );

    }


    /* =========================
       CHECK SERVICE
    ========================= */

    $service_check = "
        SELECT service_id
        FROM services
        WHERE service_id = ?
    ";

    $service_stmt = mysqli_prepare(
        $conn,
        $service_check
    );


    if (!$service_stmt) {

        die(
            "Prepare Error: "
            . mysqli_error($conn)
        );

    }


    mysqli_stmt_bind_param(
        $service_stmt,
        "i",
        $service_id
    );


    mysqli_stmt_execute(
        $service_stmt
    );


    $service_result =
        mysqli_stmt_get_result(
            $service_stmt
        );


    if (
        mysqli_num_rows(
            $service_result
        ) == 0
    ) {

        mysqli_stmt_close(
            $service_stmt
        );

        die(
            "Invalid service selected."
        );

    }


    mysqli_stmt_close(
        $service_stmt
    );


    /* =========================
       INSERT REVIEW
    ========================= */

    $query = "
        INSERT INTO reviews
        (
            traveler_id,
            destination_id,
            service_id,
            rating,
            review_text
        )
        VALUES (?, ?, ?, ?, ?)
    ";


    $stmt = mysqli_prepare(
        $conn,
        $query
    );


    if (!$stmt) {

        die(
            "Prepare Error: "
            . mysqli_error($conn)
        );

    }


    mysqli_stmt_bind_param(
        $stmt,
        "iiiis",
        $traveler_id,
        $destination_id,
        $service_id,
        $rating,
        $review_text
    );


    if (
        mysqli_stmt_execute($stmt)
    ) {

        mysqli_stmt_close($stmt);

        header(
            "Location: my_reviews.php"
        );

        exit();

    } else {

        echo "Review Error: "
            . mysqli_stmt_error($stmt);

    }

}

?>