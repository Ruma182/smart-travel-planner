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

$query = "SELECT * FROM services
          WHERE service_type = 'Hotel'
          OR service_type = 'Transport'
          ORDER BY service_id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Book Travel Service</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="booking-container">

        <h1>Book Your Travel Service</h1>

        <p>Select a hotel or transport service.</p>

        <form action="save_booking.php" method="POST">

            <label>Select Service</label>

            <select name="service_id" required>

                <option value="">
                    Select a Service
                </option>

                <?php while ($service = mysqli_fetch_assoc($result)) { ?>

                    <option
                        value="<?php echo $service["service_id"]; ?>"
                    >

                        <?php
                        echo htmlspecialchars(
                            $service["service_type"]
                        );
                        ?>

                        -

                        <?php
                        echo htmlspecialchars(
                            $service["service_name"]
                        );
                        ?>

                        -

                        ৳<?php echo $service["price"]; ?>

                    </option>

                <?php } ?>

            </select>


            <label>Booking Date</label>

            <input
                type="date"
                name="booking_date"
                required
            >


            <input
                type="number"
                name="number_of_people"
                placeholder="Number of People"
                min="1"
                required
            >


            <button type="submit">
                Submit Booking Request
            </button>

        </form>


        <a href="my_bookings.php" class="back-btn">
            View My Bookings
        </a>

        <br>

        <a href="traveler_dashboard.php" class="back-btn">
            ← Back to Dashboard
        </a>

    </div>

</body>

</html>