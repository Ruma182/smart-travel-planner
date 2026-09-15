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


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $provider_id = $_SESSION["user_id"];

    $service_type = $_POST["service_type"];

    $service_name = trim($_POST["service_name"]);

    $location = trim($_POST["location"]);

    $description = trim($_POST["description"]);

    $price = $_POST["price"];


    $query = "INSERT INTO services
    (
        provider_id,
        service_type,
        service_name,
        location,
        description,
        price
    )
    VALUES (?, ?, ?, ?, ?, ?)";


    $stmt = mysqli_prepare(
        $conn,
        $query
    );


    mysqli_stmt_bind_param(
        $stmt,
        "issssd",
        $provider_id,
        $service_type,
        $service_name,
        $location,
        $description,
        $price
    );


    if (mysqli_stmt_execute($stmt)) {


        echo "
        <script>

            alert('Service added successfully!');

            window.location.href =
                'provider_dashboard.php';

        </script>
        ";


    } else {


        echo "
        Error: " . mysqli_error($conn);


    }


}

?>