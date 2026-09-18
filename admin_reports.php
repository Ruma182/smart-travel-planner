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
// CREATE TABLES IF NOT EXISTS
// =====================================================

// BOOKINGS TABLE

$create_bookings = "CREATE TABLE IF NOT EXISTS bookings (

    booking_id INT AUTO_INCREMENT PRIMARY KEY,

    traveler_id INT NOT NULL,

    provider_id INT NOT NULL,

    service_type VARCHAR(100) NOT NULL,

    service_name VARCHAR(150) NOT NULL,

    booking_date DATE NOT NULL,

    number_of_people INT NOT NULL,

    total_price DECIMAL(10,2) NOT NULL,

    status VARCHAR(50) DEFAULT 'pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)";

mysqli_query($conn, $create_bookings);


// REVIEWS TABLE

$create_reviews = "CREATE TABLE IF NOT EXISTS reviews (

    review_id INT AUTO_INCREMENT PRIMARY KEY,

    traveler_id INT NOT NULL,

    destination_id INT NULL,

    service_id INT NULL,

    rating INT NOT NULL,

    review_text TEXT NOT NULL,

    status VARCHAR(50) DEFAULT 'approved',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)";

mysqli_query($conn, $create_reviews);


// =====================================================
// USERS STATISTICS
// =====================================================

$total_users_query = "
    SELECT COUNT(*) AS total
    FROM users
";

$total_users_result =
    mysqli_query($conn, $total_users_query);

$total_users =
    mysqli_fetch_assoc($total_users_result)["total"];


$travelers_query = "
    SELECT COUNT(*) AS total
    FROM users
    WHERE role = 'traveler'
";

$travelers_result =
    mysqli_query($conn, $travelers_query);

$total_travelers =
    mysqli_fetch_assoc($travelers_result)["total"];


$providers_query = "
    SELECT COUNT(*) AS total
    FROM users
    WHERE role = 'service_provider'
";

$providers_result =
    mysqli_query($conn, $providers_query);

$total_providers =
    mysqli_fetch_assoc($providers_result)["total"];


$active_users_query = "
    SELECT COUNT(*) AS total
    FROM users
    WHERE status = 'active'
";

$active_users_result =
    mysqli_query($conn, $active_users_query);

$active_users =
    mysqli_fetch_assoc($active_users_result)["total"];


// =====================================================
// DESTINATION STATISTICS
// =====================================================

$total_destinations_query = "
    SELECT COUNT(*) AS total
    FROM destinations
";

$total_destinations_result =
    mysqli_query(
        $conn,
        $total_destinations_query
    );

$total_destinations =
    mysqli_fetch_assoc(
        $total_destinations_result
    )["total"];


// =====================================================
// SERVICE STATISTICS
// =====================================================

$total_services_query = "
    SELECT COUNT(*) AS total
    FROM services
";

$total_services_result =
    mysqli_query(
        $conn,
        $total_services_query
    );

$total_services =
    mysqli_fetch_assoc(
        $total_services_result
    )["total"];


// =====================================================
// BOOKING STATISTICS
// =====================================================

$total_bookings_query = "
    SELECT COUNT(*) AS total
    FROM bookings
";

$total_bookings_result =
    mysqli_query(
        $conn,
        $total_bookings_query
    );

$total_bookings =
    mysqli_fetch_assoc(
        $total_bookings_result
    )["total"];


$pending_bookings_query = "
    SELECT COUNT(*) AS total
    FROM bookings
    WHERE status = 'pending'
";

$pending_bookings_result =
    mysqli_query(
        $conn,
        $pending_bookings_query
    );

$pending_bookings =
    mysqli_fetch_assoc(
        $pending_bookings_result
    )["total"];


$confirmed_bookings_query = "
    SELECT COUNT(*) AS total
    FROM bookings
    WHERE status = 'confirmed'
";

$confirmed_bookings_result =
    mysqli_query(
        $conn,
        $confirmed_bookings_query
    );

$confirmed_bookings =
    mysqli_fetch_assoc(
        $confirmed_bookings_result
    )["total"];


$rejected_bookings_query = "
    SELECT COUNT(*) AS total
    FROM bookings
    WHERE status = 'rejected'
";

$rejected_bookings_result =
    mysqli_query(
        $conn,
        $rejected_bookings_query
    );

$rejected_bookings =
    mysqli_fetch_assoc(
        $rejected_bookings_result
    )["total"];


// =====================================================
// TOTAL BOOKING REVENUE
// =====================================================

$total_revenue_query = "
    SELECT COALESCE(
        SUM(total_price),
        0
    ) AS total
    FROM bookings
    WHERE status = 'confirmed'
";

$total_revenue_result =
    mysqli_query(
        $conn,
        $total_revenue_query
    );

$total_revenue =
    mysqli_fetch_assoc(
        $total_revenue_result
    )["total"];


// =====================================================
// REVIEW STATISTICS
// =====================================================

$total_reviews_query = "
    SELECT COUNT(*) AS total
    FROM reviews
";

$total_reviews_result =
    mysqli_query(
        $conn,
        $total_reviews_query
    );

$total_reviews =
    mysqli_fetch_assoc(
        $total_reviews_result
    )["total"];


$average_rating_query = "
    SELECT COALESCE(
        AVG(rating),
        0
    ) AS average
    FROM reviews
";

$average_rating_result =
    mysqli_query(
        $conn,
        $average_rating_query
    );

$average_rating =
    mysqli_fetch_assoc(
        $average_rating_result
    )["average"];

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
        Reports & Analytics - Smart Travel Planner
    </title>

    <link
        rel="stylesheet"
        href="style.css"
    >

    <style>

        .reports-container {

            width: 90%;

            max-width: 1200px;

            margin: 45px auto;

            padding: 35px;

            background: white;

            border-radius: 25px;

            box-shadow:
                0 15px 45px rgba(16, 42, 67, 0.10);

        }


        .reports-container h1 {

            color: #102a43;

            margin-bottom: 8px;

        }


        .reports-description {

            color: #52606d;

            margin-bottom: 35px;

        }


        .report-section {

            margin-bottom: 35px;

        }


        .report-section h2 {

            color: #102a43;

            margin-bottom: 18px;

            font-size: 22px;

        }


        .report-grid {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 18px;

        }


        .report-card {

            padding: 25px;

            background: #f8fbfc;

            border: 1px solid #e6eef1;

            border-radius: 17px;

            transition: 0.3s;

        }


        .report-card:hover {

            transform: translateY(-5px);

            box-shadow:
                0 12px 30px
                rgba(16, 42, 67, 0.10);

        }


        .report-card h3 {

            color: #52606d;

            font-size: 14px;

            margin-bottom: 12px;

        }


        .report-number {

            color: #0b7285;

            font-size: 30px;

            font-weight: 800;

        }


        .report-money {

            color: #198754;

            font-size: 25px;

            font-weight: 800;

        }


        .rating-number {

            color: #f59f00;

            font-size: 30px;

            font-weight: 800;

        }


        .back-btn {

            display: inline-block;

            margin-top: 10px;

        }


        @media (max-width: 900px) {

            .report-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }

        }


        @media (max-width: 600px) {

            .reports-container {

                width: 94%;

                padding: 25px 18px;

            }


            .report-grid {

                grid-template-columns: 1fr;

            }

        }

    </style>

</head>


<body>


<div class="reports-container">


    <h1>
        Reports & Analytics
    </h1>


    <p class="reports-description">

        Monitor platform usage, users, bookings,
        services, destinations and traveler feedback.

    </p>


    <!-- =================================================
         USER REPORT
    ================================================== -->

    <div class="report-section">

        <h2>
            User Overview
        </h2>


        <div class="report-grid">


            <div class="report-card">

                <h3>
                    Total Users
                </h3>

                <div class="report-number">
                    <?php echo $total_users; ?>
                </div>

            </div>


            <div class="report-card">

                <h3>
                    Travelers
                </h3>

                <div class="report-number">
                    <?php echo $total_travelers; ?>
                </div>

            </div>


            <div class="report-card">

                <h3>
                    Service Providers
                </h3>

                <div class="report-number">
                    <?php echo $total_providers; ?>
                </div>

            </div>


            <div class="report-card">

                <h3>
                    Active Users
                </h3>

                <div class="report-number">
                    <?php echo $active_users; ?>
                </div>

            </div>


        </div>

    </div>


    <!-- =================================================
         PLATFORM REPORT
    ================================================== -->

    <div class="report-section">

        <h2>
            Platform Overview
        </h2>


        <div class="report-grid">


            <div class="report-card">

                <h3>
                    Destinations
                </h3>

                <div class="report-number">
                    <?php echo $total_destinations; ?>
                </div>

            </div>


            <div class="report-card">

                <h3>
                    Services
                </h3>

                <div class="report-number">
                    <?php echo $total_services; ?>
                </div>

            </div>


            <div class="report-card">

                <h3>
                    Total Bookings
                </h3>

                <div class="report-number">
                    <?php echo $total_bookings; ?>
                </div>

            </div>


            <div class="report-card">

                <h3>
                    Total Reviews
                </h3>

                <div class="report-number">
                    <?php echo $total_reviews; ?>
                </div>

            </div>


        </div>

    </div>


    <!-- =================================================
         BOOKING REPORT
    ================================================== -->

    <div class="report-section">

        <h2>
            Booking Analytics
        </h2>


        <div class="report-grid">


            <div class="report-card">

                <h3>
                    Pending Bookings
                </h3>

                <div class="report-number">
                    <?php echo $pending_bookings; ?>
                </div>

            </div>


            <div class="report-card">

                <h3>
                    Confirmed Bookings
                </h3>

                <div class="report-number">
                    <?php echo $confirmed_bookings; ?>
                </div>

            </div>


            <div class="report-card">

                <h3>
                    Rejected Bookings
                </h3>

                <div class="report-number">
                    <?php echo $rejected_bookings; ?>
                </div>

            </div>


            <div class="report-card">

                <h3>
                    Confirmed Revenue
                </h3>

                <div class="report-money">

                    ৳<?php

                    echo number_format(
                        $total_revenue,
                        2
                    );

                    ?>

                </div>

            </div>


        </div>

    </div>


    <!-- =================================================
         REVIEW REPORT
    ================================================== -->

    <div class="report-section">

        <h2>
            Traveler Feedback
        </h2>


        <div class="report-grid">


            <div class="report-card">

                <h3>
                    Total Reviews
                </h3>

                <div class="report-number">
                    <?php echo $total_reviews; ?>
                </div>

            </div>


            <div class="report-card">

                <h3>
                    Average Rating
                </h3>

                <div class="rating-number">

                    <?php

                    echo number_format(
                        $average_rating,
                        1
                    );

                    ?>

                    / 5

                </div>

            </div>


        </div>

    </div>


    <a
        href="admin_dashboard.php"
        class="back-btn"
    >

        ← Back to Admin Dashboard

    </a>


</div>


</body>

</html>