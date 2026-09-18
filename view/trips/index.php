
<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Trip Plans</title>

    <link rel="stylesheet"
          href="/web-technology/smart-travel-planner/style.css">

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

                        ৳<?php
                        echo htmlspecialchars($trip["transport_cost"]);
                        ?>

                    </p>


                    <p>

                        <strong>Hotel Cost:</strong>

                        ৳<?php
                        echo htmlspecialchars($trip["hotel_cost"]);
                        ?>

                    </p>


                    <p>

                        <strong>Food Cost:</strong>

                        ৳<?php
                        echo htmlspecialchars($trip["food_cost"]);
                        ?>

                    </p>


                    <p>

                        <strong>Other Cost:</strong>

                        ৳<?php
                        echo htmlspecialchars($trip["other_cost"]);
                        ?>

                    </p>


                    <h3>

                        Total Budget:

                        ৳<?php
                        echo htmlspecialchars($trip["total_budget"]);
                        ?>

                    </h3>

                </div>


        <?php

            }

        } else {

        ?>

            <p class="no-trip">
                You have not created any trip plan yet.
            </p>

        <?php

        }

        ?>


        <a
            href="/web-technology/smart-travel-planner/trip_mvc.php"
            class="create-trip-btn"
        >
            + Create New Trip
        </a>


        <br>


        <a
            href="/web-technology/smart-travel-planner/traveler_dashboard.php"
            class="back-btn"
        >
            ← Back to Dashboard
        </a>

    </div>

</body>

</html>

