<?php

session_start();

include 'config/database.php';


if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


if ($_SESSION["role"] != "admin") {

    header("Location: login.php");
    exit();

}


/*
Get all services with provider information
*/

$query = "SELECT services.*,
                 users.name AS provider_name,
                 users.email AS provider_email

          FROM services

          JOIN users
          ON services.provider_id = users.user_id

          ORDER BY services.service_id DESC";


$result = mysqli_query($conn, $query);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Services - Smart Travel Planner</title>

    <link rel="stylesheet" href="style.css">

</head>


<body>


<div class="my-trips-container">


    <h1>Manage Services</h1>

    <p>View and manage all travel services added by providers.</p>


    <?php if (mysqli_num_rows($result) > 0) { ?>


        <?php while ($service = mysqli_fetch_assoc($result)) { ?>


            <div class="trip-card">


                <h2>

                    <?php
                    echo htmlspecialchars(
                        $service["service_name"]
                    );
                    ?>

                </h2>


                <p>

                    <strong>Service Type:</strong>

                    <?php
                    echo htmlspecialchars(
                        $service["service_type"]
                    );
                    ?>

                </p>


                <p>

                    <strong>Provider:</strong>

                    <?php
                    echo htmlspecialchars(
                        $service["provider_name"]
                    );
                    ?>

                </p>


                <p>

                    <strong>Provider Email:</strong>

                    <?php
                    echo htmlspecialchars(
                        $service["provider_email"]
                    );
                    ?>

                </p>


                <p>

                    <strong>Location:</strong>

                    <?php
                    echo htmlspecialchars(
                        $service["location"]
                    );
                    ?>

                </p>


                <p>

                    <strong>Description:</strong>

                    <?php
                    echo htmlspecialchars(
                        $service["description"]
                    );
                    ?>

                </p>


                <h3>

                    Price:
                    ৳<?php
                    echo htmlspecialchars(
                        $service["price"]
                    );
                    ?>

                </h3>


                <a
                    href="delete_service.php?id=<?php
                    echo $service["service_id"];
                    ?>"
                    class="reject-btn"
                    onclick="return confirm(
                        'Are you sure you want to delete this service?'
                    );"
                >

                    Delete Service

                </a>


            </div>


        <?php } ?>


    <?php } else { ?>


        <p class="no-trip">

            No services found.

        </p>


    <?php } ?>


    <a href="admin_dashboard.php"
       class="back-btn">

        ← Back to Admin Dashboard

    </a>


</div>


</body>

</html>