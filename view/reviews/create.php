<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Add Review</title>

    <link rel="stylesheet"
          href="/web-technology/smart-travel-planner/style.css">

</head>


<body>


<div class="booking-container">


    <h1>Review & Rating</h1>

    <p>
        Share your travel experience.
    </p>


    <form
        action="/web-technology/smart-travel-planner/review_mvc.php?action=store"
        method="POST"
    >


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



    <a
        href="/web-technology/smart-travel-planner/review_mvc.php?action=my_reviews"
        class="create-trip-btn"
    >

        My Reviews

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