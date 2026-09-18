<?php

session_start();

include 'config/database.php';


// =====================================================
// LOGIN CHECK
// =====================================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


// =====================================================
// TRAVELER ROLE CHECK
// =====================================================

if ($_SESSION["role"] != "traveler") {

    header("Location: login.php");
    exit();

}


// =====================================================
// CREATE BOOKINGS TABLE IF NOT EXISTS
// =====================================================

$create_table = "CREATE TABLE IF NOT EXISTS bookings (

    booking_id INT AUTO_INCREMENT PRIMARY KEY,

    traveler_id INT NOT NULL,

    provider_id INT NOT NULL,

    service_type VARCHAR(100) NOT NULL,

    service_name VARCHAR(150) NOT NULL,

    booking_date DATE NOT NULL,

    number_of_people INT NOT NULL,

    total_price DECIMAL(10,2) NOT NULL,

    status VARCHAR(50) DEFAULT 'pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)";


if (!mysqli_query($conn, $create_table)) {

    die(
        "Booking table creation failed: "
        . mysqli_error($conn)
    );

}


// =====================================================
// SAVE BOOKING
// =====================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // -------------------------------------------------
    // GET TRAVELER INFORMATION
    // -------------------------------------------------

    $traveler_id = $_SESSION["user_id"];


    $service_id = intval(
        $_POST["service_id"]
    );


    $booking_date = $_POST["booking_date"];


    $number_of_people = intval(
        $_POST["number_of_people"]
    );


    // -------------------------------------------------
    // VALIDATION
    // -------------------------------------------------

    if (
        empty($service_id) ||
        empty($booking_date) ||
        $number_of_people < 1
    ) {

        die("Please provide valid booking information.");

    }


    // =================================================
    // GET SERVICE INFORMATION
    // =================================================

    $service_query = "
        SELECT *
        FROM services
        WHERE service_id = ?
    ";


    $stmt = mysqli_prepare(
        $conn,
        $service_query
    );


    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $service_id
    );


    mysqli_stmt_execute($stmt);


    $service_result =
        mysqli_stmt_get_result($stmt);


    // =================================================
    // CHECK SERVICE
    // =================================================

    if (
        mysqli_num_rows($service_result) == 1
    ) {


        $service =
            mysqli_fetch_assoc($service_result);


        // -------------------------------------------------
        // SERVICE DATA
        // -------------------------------------------------

        $provider_id =
            intval($service["provider_id"]);


        $service_type =
            $service["service_type"];


        $service_name =
            $service["service_name"];


        $price =
            floatval($service["price"]);


        // -------------------------------------------------
        // CALCULATE TOTAL PRICE
        // -------------------------------------------------

        $total_price =
            $price * $number_of_people;


        // =================================================
        // INSERT BOOKING
        // =================================================

        $query = "
            INSERT INTO bookings
            (
                traveler_id,
                provider_id,
                service_type,
                service_name,
                booking_date,
                number_of_people,
                total_price,
                status
            )

            VALUES
            (?, ?, ?, ?, ?, ?, ?, 'pending')
        ";


        $stmt = mysqli_prepare(
            $conn,
            $query
        );


        mysqli_stmt_bind_param(
            $stmt,
            "iisssid",
            $traveler_id,
            $provider_id,
            $service_type,
            $service_name,
            $booking_date,
            $number_of_people,
            $total_price
        );


        // =================================================
        // SUCCESS
        // =================================================

        if (mysqli_stmt_execute($stmt)) {


            echo "

            <script>

                alert(
                    'Booking Request Submitted Successfully!'
                );

                window.location.href =
                    'my_bookings.php';

            </script>

            ";


        } else {


            echo "

            <script>

                alert(
                    'Booking could not be submitted.'
                );

                window.location.href =
                    'booking.php';

            </script>

            ";

        }


        mysqli_stmt_close($stmt);


    } else {


        echo "

        <script>

            alert(
                'Selected service was not found.'
            );

            window.location.href =
                'booking.php';

        </script>

        ";

    }


} else {


    header("Location: booking.php");
    exit();

}

?>