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
// GET DESTINATIONS
// =========================

$sql = "SELECT * FROM destinations ORDER BY destination_id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Destinations - Smart Travel Planner</title>

    <link rel="stylesheet" href="style.css">

    <style>

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 40px auto;
        }

        .destination {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .destination h2 {
            margin-top: 0;
        }

        .cost {
            font-weight: bold;
            color: #198754;
        }

        .edit-btn,
        .delete-btn,
        .back-btn {
            display: inline-block;
            padding: 9px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            margin-right: 6px;
        }

        .edit-btn {
            background: #0d6efd;
        }

        .delete-btn {
            background: #dc3545;
        }

        .back-btn {
            background: #6c757d;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Manage My Destinations</h1>

    <p>
        View and manage available local destinations.
    </p>


    <a href="add_destination.php"
       class="edit-btn">

        + Add Destination

    </a>

    <a href="local_explorer_dashboard.php"
       class="back-btn">

        ← Back to Dashboard

    </a>


    <br><br>


    <?php

    if (mysqli_num_rows($result) > 0) {

        while ($destination = mysqli_fetch_assoc($result)) {

    ?>

        <div class="destination">

            <h2>
                <?php
                echo htmlspecialchars($destination["name"]);
                ?>
            </h2>


            <p>

                <strong>Location:</strong>

                <?php
                echo htmlspecialchars($destination["location"]);
                ?>

            </p>


            <p>

                <strong>Description:</strong><br>

                <?php
                echo nl2br(
                    htmlspecialchars(
                        $destination["description"]
                    )
                );
                ?>

            </p>


            <p class="cost">

                Estimated Cost:

                ৳<?php
                echo number_format(
                    $destination["estimated_cost"],
                    2
                );
                ?>

            </p>


            <a
                href="manage_destinations.php?edit=<?php echo $destination["destination_id"]; ?>"
                class="edit-btn">

                Edit

            </a>


            <a
                href="manage_destinations.php?delete=<?php echo $destination["destination_id"]; ?>"
                class="delete-btn"
                onclick="return confirm('Are you sure you want to delete this destination?');">

                Delete

            </a>

        </div>

    <?php

        }

    } else {

    ?>

        <p>
            No destinations available.
        </p>

    <?php

    }

    ?>

</div>

</body>
</html>