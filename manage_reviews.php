<?php

session_start();

include 'config/database.php';


// =====================================================
// LOGIN CHECK
// =====================================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


// =====================================================
// ADMIN ROLE CHECK
// =====================================================

if ($_SESSION["role"] != "admin") {

    header("Location: login.php");
    exit();

}


// =====================================================
// CREATE REVIEWS TABLE IF NOT EXISTS
// =====================================================

$create_table = "CREATE TABLE IF NOT EXISTS reviews (

    review_id INT AUTO_INCREMENT PRIMARY KEY,

    traveler_id INT NOT NULL,

    destination_id INT NULL,

    service_id INT NULL,

    rating INT NOT NULL,

    review_text TEXT NOT NULL,

    status VARCHAR(50) DEFAULT 'approved',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)";


if (!mysqli_query($conn, $create_table)) {

    die(
        "Reviews table creation failed: "
        . mysqli_error($conn)
    );

}


// =====================================================
// DELETE REVIEW
// =====================================================

if (isset($_GET["delete"])) {

    $review_id = intval($_GET["delete"]);


    $delete_query = "
        DELETE FROM reviews
        WHERE review_id = ?
    ";


    $stmt = mysqli_prepare(
        $conn,
        $delete_query
    );


    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $review_id
    );


    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);


    header("Location: manage_reviews.php");

    exit();

}


// =====================================================
// GET ALL REVIEWS
// =====================================================

$query = "
    SELECT *
    FROM reviews
    ORDER BY review_id DESC
";


$result = mysqli_query(
    $conn,
    $query
);


if (!$result) {

    die(
        "Unable to load reviews: "
        . mysqli_error($conn)
    );

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Manage Reviews - Smart Travel Planner
    </title>

    <link
        rel="stylesheet"
        href="style.css"
    >


    <style>

        .reviews-container {

            width: 90%;

            max-width: 1100px;

            margin: 45px auto;

            padding: 35px;

            background: white;

            border-radius: 22px;

            box-shadow:
                0 15px 45px rgba(16, 42, 67, 0.10);

        }


        .reviews-container h1 {

            color: #102a43;

            margin-bottom: 8px;

        }


        .reviews-container > p {

            color: #52606d;

            margin-bottom: 30px;

        }


        .review-card {

            background: #f8fbfc;

            border: 1px solid #e6eef1;

            border-radius: 17px;

            padding: 25px;

            margin-bottom: 18px;

        }


        .review-card h2 {

            color: #0b7285;

            margin-bottom: 15px;

        }


        .review-card p {

            color: #52606d;

            line-height: 1.7;

            margin: 8px 0;

        }


        .review-card strong {

            color: #102a43;

        }


        .rating {

            color: #f59f00;

            font-size: 18px;

            font-weight: 700;

        }


        .review-status {

            display: inline-block;

            padding: 6px 12px;

            border-radius: 20px;

            background: #d1e7dd;

            color: #0f5132;

            font-size: 13px;

            font-weight: 700;

        }


        .review-actions {

            margin-top: 20px;

            padding-top: 18px;

            border-top: 1px solid #e6eef1;

        }


        .delete-review-btn {

            display: inline-block;

            padding: 10px 17px;

            border-radius: 9px;

            background: #ef476f;

            color: white;

            text-decoration: none;

            font-weight: 700;

        }


        .delete-review-btn:hover {

            background: #d6335c;

        }


        .no-review {

            text-align: center;

            padding: 40px;

            background: #f8fbfc;

            border-radius: 15px;

            color: #52606d;

        }


        .back-btn {

            display: inline-block;

            margin-top: 20px;

        }

    </style>

</head>


<body>


<div class="reviews-container">


    <h1>
        Manage Reviews
    </h1>


    <p>
        View and manage traveler reviews and ratings.
    </p>


    <?php if (mysqli_num_rows($result) > 0) { ?>


        <?php while ($review = mysqli_fetch_assoc($result)) { ?>


            <div class="review-card">


                <h2>
                    Traveler Review
                </h2>


                <p>

                    <strong>
                        Review ID:
                    </strong>

                    <?php
                    echo $review["review_id"];
                    ?>

                </p>


                <p>

                    <strong>
                        Traveler ID:
                    </strong>

                    <?php
                    echo $review["traveler_id"];
                    ?>

                </p>


                <?php if (!empty($review["destination_id"])) { ?>

                    <p>

                        <strong>
                            Destination ID:
                        </strong>

                        <?php
                        echo $review["destination_id"];
                        ?>

                    </p>

                <?php } ?>


                <?php if (!empty($review["service_id"])) { ?>

                    <p>

                        <strong>
                            Service ID:
                        </strong>

                        <?php
                        echo $review["service_id"];
                        ?>

                    </p>

                <?php } ?>


                <p>

                    <strong>
                        Rating:
                    </strong>

                    <span class="rating">

                        <?php

                        $rating =
                            intval($review["rating"]);

                        echo str_repeat(
                            "★",
                            $rating
                        );

                        echo str_repeat(
                            "☆",
                            5 - $rating
                        );

                        ?>

                    </span>

                </p>


                <p>

                    <strong>
                        Review:
                    </strong>

                    <br>

                    <?php

                    echo nl2br(
                        htmlspecialchars(
                            $review["review_text"]
                        )
                    );

                    ?>

                </p>


                <p>

                    <strong>
                        Status:
                    </strong>


                    <span class="review-status">

                        <?php

                        echo htmlspecialchars(
                            $review["status"]
                        );

                        ?>

                    </span>

                </p>


                <p>

                    <strong>
                        Created:
                    </strong>

                    <?php

                    echo htmlspecialchars(
                        $review["created_at"]
                    );

                    ?>

                </p>


                <div class="review-actions">


                    <a
                        href="manage_reviews.php?delete=<?php
                        echo $review["review_id"];
                        ?>"
                        class="delete-review-btn"
                        onclick="return confirm(
                            'Are you sure you want to delete this review?'
                        );"
                    >

                        Delete Review

                    </a>


                </div>


            </div>


        <?php } ?>


    <?php } else { ?>


        <div class="no-review">

            <h2>
                No Reviews Found
            </h2>

            <p>
                There are currently no traveler reviews.
            </p>

        </div>


    <?php } ?>


    <a
        href="admin_dashboard.php"
        class="back-btn"
    >

        ← Back to Admin Dashboard

    </a>


</div>


</body>

</html>