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

$query = "SELECT * FROM trip_plans
          WHERE user_id = ?
          ORDER BY trip_id DESC";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $user_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Trip Plans</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="my-trips-container">

        <h1>My Trip Plans</h1>

        <p>View all your saved travel plans.</p>

        <?php

        if (mysqli_num_rows($result) > 0) {

            while ($trip = mysqli_fetch_assoc($result)) {

        ?>

                <div class="trip-card">

                    <h2>
                        <?php
                        echo htmlspecialchars($trip["destination"]);
                        ?>
                    </h2>

                    <p>
                        <strong>Travel Date:</strong>

                        <?php
                        echo htmlspecialchars($trip["start_date"]);
                        ?>

                        to

                        <?php
                        echo htmlspecialchars($trip["end_date"]);
                        ?>
                    </p>

                    <p>
                        <strong>Transport Cost:</strong>
                        ৳<?php echo $trip["transport_cost"]; ?>
                    </p>

                    <p>
                        <strong>Hotel Cost:</strong>
                        ৳<?php echo $trip["hotel_cost"]; ?>
                    </p>

                    <p>
                        <strong>Food Cost:</strong>
                        ৳<?php echo $trip["food_cost"]; ?>
                    </p>

                    <p>
                        <strong>Other Cost:</strong>
                        ৳<?php echo $trip["other_cost"]; ?>
                    </p>

                    <h3>
                        Total Budget:
                        ৳<?php echo $trip["total_budget"]; ?>
                    </h3>

                </div>

        <?php

            }

        } else {

            echo "<p class='no-trip'>
                    You have not created any trip plan yet.
                  </p>";

        }

        ?>

        <a href="trip_planner.php" class="create-trip-btn">
            + Create New Trip
        </a>

        <br>

        <a href="traveler_dashboard.php" class="back-btn">
            ← Back to Dashboard
        </a>

    </div>

</body>

</html>