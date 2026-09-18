<?php

session_start();

include 'config/database.php';


// =========================
// LOGIN CHECK
// =========================

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


// =========================
// ROLE CHECK
// =========================

if ($_SESSION["role"] != "local_explorer") {
    header("Location: login.php");
    exit();
}


// =========================
// FORM SUBMISSION CHECK
// =========================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $location = trim($_POST["location"]);
    $description = trim($_POST["description"]);
    $estimated_cost = floatval($_POST["estimated_cost"]);


    // =========================
    // VALIDATION
    // =========================

    if (
        empty($name) ||
        empty($location) ||
        empty($description) ||
        $estimated_cost < 0
    ) {

        die("Please provide valid destination information.");

    }


    // =========================
    // INSERT DESTINATION
    // =========================

    $sql = "INSERT INTO destinations
            (name, location, description, estimated_cost)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {

        die("Database error: " . mysqli_error($conn));

    }


    mysqli_stmt_bind_param(
        $stmt,
        "sssd",
        $name,
        $location,
        $description,
        $estimated_cost
    );


    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        header("Location: manage_destinations.php");
        exit();

    } else {

        echo "Failed to add destination: "
             . mysqli_stmt_error($stmt);

    }


    mysqli_stmt_close($stmt);

} else {

    header("Location: add_destination.php");
    exit();

}

?>