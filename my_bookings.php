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


$user_id = $_SESSION["user_id"];

$query = "SELECT * FROM bookings
          WHERE traveler_id = ?
          ORDER BY booking_id DESC";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Bookings</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="my-bookings-container">

        <h1>My Bookings</h1>

        <p>Track your hotel and transport booking requests.</p>

        <?php if (mysqli_num_rows($result) > 0) { ?>

            <?php while ($booking = mysqli_fetch_assoc($result)) { ?>

                <div class="booking-card">

                    <h2>
                        <?php
                        echo htmlspecialchars($booking["service_name"]);
                        ?>
                    </h2>

                    <p>
                        <strong>Service Type:</strong>
                        <?php echo htmlspecialchars($booking["service_type"]); ?>
                    </p>

                    <p>
                        <strong>Booking Date:</strong>
                        <?php echo $booking["booking_date"]; ?>
                    </p>

                    <p>
                        <strong>Number of People:</strong>
                        <?php echo $booking["number_of_people"]; ?>
                    </p>

                    <p>
                        <strong>Total Price:</strong>
                        ৳<?php echo $booking["total_price"]; ?>
                    </p>

                    <p>
                        <strong>Status:</strong>

                        <span class="booking-status">
                            <?php
                            echo htmlspecialchars($booking["status"]);
                            ?>
                        </span>
                    </p>

                </div>

            <?php } ?>

        <?php } else { ?>

            <p class="no-booking">
                You have not made any booking yet.
            </p>

        <?php } ?>


        <a href="booking.php" class="create-booking-btn">
            + New Booking
        </a>

        <br>

        <a href="traveler_dashboard.php" class="back-btn">
            ← Back to Dashboard
        </a>

    </div>

</body>

</html>