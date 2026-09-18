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


/* =========================
   GET DESTINATIONS
========================= */

$destination_query = "
    SELECT destination_id, name
    FROM destinations
    ORDER BY name ASC
";

$destination_result = mysqli_query($conn, $destination_query);


/* =========================
   GET SERVICES
========================= */

$service_query = "
    SELECT service_id, service_name
    FROM services
    ORDER BY service_name ASC
";

$service_result = mysqli_query($conn, $service_query);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Add Review</title>

    <link rel="stylesheet"
          href="style.css">

</head>


<body>


<div class="booking-container">


    <h1>Review & Rating</h1>

    <p>
        Share your travel experience.
    </p>


    <form action="save_review.php"
          method="POST">


        <!-- DESTINATION -->

        <label>
            Select Destination
        </label>

        <select name="destination_id"
                required>

            <option value="">
                Select Destination
            </option>


            <?php while (
                $destination =
                mysqli_fetch_assoc($destination_result)
            ) { ?>

                <option value="<?php
                    echo $destination["destination_id"];
                ?>">

                    <?php
                    echo htmlspecialchars(
                        $destination["name"]
                    );
                    ?>

                </option>

            <?php } ?>

        </select>



        <!-- SERVICE -->

        <label>
            Select Service
        </label>

        <select name="service_id"
                required>

            <option value="">
                Select Service
            </option>


            <?php while (
                $service =
                mysqli_fetch_assoc($service_result)
            ) { ?>

                <option value="<?php
                    echo $service["service_id"];
                ?>">

                    <?php
                    echo htmlspecialchars(
                        $service["service_name"]
                    );
                    ?>

                </option>

            <?php } ?>

        </select>



        <!-- RATING -->

        <label>
            Rating
        </label>

        <select name="rating"
                required>

            <option value="">
                Select Rating
            </option>

            <option value="5">
                5 - Excellent
            </option>

            <option value="4">
                4 - Very Good
            </option>

            <option value="3">
                3 - Good
            </option>

            <option value="2">
                2 - Average
            </option>

            <option value="1">
                1 - Poor
            </option>

        </select>



        <!-- REVIEW -->

        <label>
            Write Your Review
        </label>

        <textarea
            name="review_text"
            placeholder="Write your experience..."
            required
        ></textarea>



        <button type="submit">

            Submit Review

        </button>


    </form>



    <a href="my_reviews.php"
       class="create-trip-btn">

        My Reviews

    </a>


    <br>


    <a href="traveler_dashboard.php"
       class="back-btn">

        ← Back to Dashboard

    </a>


</div>


</body>

</html>