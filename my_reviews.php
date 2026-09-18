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

$traveler_id = $_SESSION["user_id"];

$query = "
    SELECT 
        reviews.*,
        destinations.name AS destination_name

    FROM reviews

    JOIN destinations
        ON reviews.destination_id =
           destinations.destination_id

    WHERE reviews.traveler_id = ?

    ORDER BY reviews.review_id DESC
";

$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Prepare Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $traveler_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Reviews</title>

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="my-trips-container">

    <h1>My Reviews</h1>

    <p>
        Your submitted reviews and ratings.
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

                    <strong>Rating:</strong>

                    <?php
                    echo str_repeat(
                        "★",
                        $review["rating"]
                    );

                    echo str_repeat(
                        "☆",
                        5 - $review["rating"]
                    );
                    ?>

                </p>

                <p>

                    <strong>Review:</strong><br>

                    <?php
                    echo htmlspecialchars(
                        $review["review_text"]
                    );
                    ?>

                </p>

                <a
                    href="delete_review.php?id=<?php
                    echo $review["review_id"];
                    ?>"
                    class="reject-btn"
                    onclick="return confirm('Are you sure you want to delete this review?');"
                >
                    Delete Review
                </a>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p class="no-trip">
            You have not submitted any reviews yet.
        </p>

    <?php } ?>

    <a
        href="add_review.php"
        class="create-trip-btn"
    >
        + Add New Review
    </a>

    <br>

    <a
        href="traveler_dashboard.php"
        class="back-btn"
    >
        ← Back to Dashboard
    </a>

</div>

</body>
</html>