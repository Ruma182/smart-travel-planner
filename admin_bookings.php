
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
// GET ALL BOOKINGS
// =====================================================

$query = "
    SELECT *
    FROM bookings
    ORDER BY booking_id DESC
";


$result = mysqli_query(
    $conn,
    $query
);


if (!$result) {

    die(
        "Unable to load bookings: "
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
        View All Bookings - Smart Travel Planner
    </title>


    <link
        rel="stylesheet"
        href="style.css"
    >


    <style>

        .admin-bookings-container {

            width: 90%;

            max-width: 1200px;

            margin: 45px auto;

            padding: 35px;

            background: white;

            border-radius: 22px;

            box-shadow:
                0 15px 45px rgba(16, 42, 67, 0.10);

        }


        .admin-bookings-container h1 {

            color: #102a43;

            margin-bottom: 8px;

        }


        .admin-bookings-container > p {

            color: #52606d;

            margin-bottom: 30px;

        }


        .booking-card {

            background: #f8fbfc;

            border: 1px solid #e6eef1;

            border-radius: 16px;

            padding: 25px;

            margin-bottom: 18px;

        }


        .booking-card h2 {

            color: #0b7285;

            margin-bottom: 18px;

        }


        .booking-card p {

            color: #52606d;

            line-height: 1.7;

            margin: 7px 0;

        }


        .booking-card strong {

            color: #102a43;

        }


        .booking-status {

            display: inline-block;

            padding: 6px 12px;

            border-radius: 20px;

            background: #fff3cd;

            color: #856404;

            font-weight: 700;

            font-size: 13px;

        }


        .booking-actions {

            display: flex;

            gap: 12px;

            margin-top: 20px;

        }


        .confirm-btn {

            display: inline-block;

            padding: 10px 20px;

            background: #198754;

            color: white;

            text-decoration: none;

            border-radius: 8px;

            font-weight: 600;

        }


        .reject-btn {

            display: inline-block;

            padding: 10px 20px;

            background: #dc3545;

            color: white;

            text-decoration: none;

            border-radius: 8px;

            font-weight: 600;

        }


        .confirm-btn:hover {

            background: #146c43;

        }


        .reject-btn:hover {

            background: #bb2d3b;

        }


        .no-booking {

            text-align: center;

            padding: 40px;

            color: #52606d;

            background: #f8fbfc;

            border-radius: 15px;

        }


        .back-btn {

            display: inline-block;

            margin-top: 20px;

        }

    </style>

</head>


<body>


<div class="admin-bookings-container">


    <h1>
        View All Bookings
    </h1>


    <p>
        View, approve, or reject hotel and transport booking requests.
    </p>


    <?php if (mysqli_num_rows($result) > 0) { ?>


        <?php while ($booking = mysqli_fetch_assoc($result)) { ?>


            <div class="booking-card">


                <h2>

                    <?php

                    echo htmlspecialchars(
                        $booking["service_name"]
                    );

                    ?>

                </h2>


                <p>

                    <strong>
                        Booking ID:
                    </strong>

                    <?php

                    echo $booking["booking_id"];

                    ?>

                </p>


                <p>

                    <strong>
                        Traveler ID:
                    </strong>

                    <?php

                    echo $booking["traveler_id"];

                    ?>

                </p>


                <p>

                    <strong>
                        Provider ID:
                    </strong>

                    <?php

                    echo $booking["provider_id"];

                    ?>

                </p>


                <p>

                    <strong>
                        Service Type:
                    </strong>

                    <?php

                    echo htmlspecialchars(
                        $booking["service_type"]
                    );

                    ?>

                </p>


                <p>

                    <strong>
                        Booking Date:
                    </strong>

                    <?php

                    echo htmlspecialchars(
                        $booking["booking_date"]
                    );

                    ?>

                </p>


                <p>

                    <strong>
                        Number of People:
                    </strong>

                    <?php

                    echo $booking["number_of_people"];

                    ?>

                </p>


                <p>

                    <strong>
                        Total Price:
                    </strong>

                    ৳<?php

                    echo number_format(
                        $booking["total_price"],
                        2
                    );

                    ?>

                </p>


                <p>

                    <strong>
                        Status:
                    </strong>


                    <span class="booking-status">

                        <?php

                        echo htmlspecialchars(
                            ucfirst(
                                $booking["status"]
                            )
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
                        $booking["created_at"]
                    );

                    ?>

                </p>


                <!-- =========================
                     APPROVE / REJECT BUTTONS
                ========================== -->

                <?php if (
                    $booking["status"] == "pending"
                ) { ?>


                    <div class="booking-actions">


                        <a
                            href="approve_booking.php?booking_id=<?php
                                echo $booking["booking_id"];
                            ?>"
                            class="confirm-btn"
                        >

                            Approve

                        </a>


                        <a
                            href="reject_booking.php?booking_id=<?php
                                echo $booking["booking_id"];
                            ?>"
                            class="reject-btn"
                        >

                            Reject

                        </a>


                    </div>


                <?php } ?>


            </div>


        <?php } ?>


    <?php } else { ?>


        <div class="no-booking">


            <h2>
                No Bookings Found
            </h2>


            <p>
                There are currently no booking requests.
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

