<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Reviews</title>

    <link rel="stylesheet"
          href="/web-technology/smart-travel-planner/style.css">

</head>


<body>


<div class="my-trips-container">


    <h1>My Reviews</h1>

    <p>
        View the reviews and ratings you have submitted.
    </p>


    <?php if (mysqli_num_rows($result) > 0) { ?>


        <?php while ($review = mysqli_fetch_assoc($result)) { ?>


            <div class="trip-card">


                <h2>
                    <?php
                    echo htmlspecialchars(
                        $review["destination_name"]
                    );
                    ?>
                </h2>


                <p>
                    <strong>Service:</strong>
                    <?php
                    echo htmlspecialchars(
                        $review["service_name"]
                    );
                    ?>
                </p>


                <p>
                    <strong>Rating:</strong>
                    <?php
                    echo htmlspecialchars(
                        $review["rating"]
                    );
                    ?>
                    / 5
                </p>


                <p>
                    <strong>Your Review:</strong>
                    <?php
                    echo htmlspecialchars(
                        $review["review_text"]
                    );
                    ?>
                </p>


                <p>
                    <strong>Date:</strong>
                    <?php
                    echo htmlspecialchars(
                        $review["created_at"]
                    );
                    ?>
                </p>


            </div>


        <?php } ?>


    <?php } else { ?>


        <p class="no-trip">
            You have not submitted any review yet.
        </p>


    <?php } ?>


    <a
        href="/web-technology/smart-travel-planner/review_mvc.php?action=create"
        class="create-trip-btn"
    >
        + Add New Review
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