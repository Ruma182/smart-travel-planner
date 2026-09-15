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
// ADMIN CHECK
// =========================

if ($_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}


// =========================
// GET USERS
// =========================

$query = "SELECT
            user_id,
            name,
            email,
            role,
            status,
            created_at
          FROM users
          ORDER BY user_id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Users - Smart Travel Planner</title>

    <link rel="stylesheet"
          href="style.css">

</head>


<body>


<div class="my-trips-container">


    <h1>Manage Users</h1>

    <p>
        View and manage Traveler, Service Provider and Local Explorer accounts.
    </p>


    <?php if ($result && mysqli_num_rows($result) > 0) { ?>


        <?php while ($user = mysqli_fetch_assoc($result)) { ?>


            <div class="trip-card">


                <h2>
                    <?php
                    echo htmlspecialchars($user["name"]);
                    ?>
                </h2>


                <p>

                    <strong>Email:</strong>

                    <?php
                    echo htmlspecialchars($user["email"]);
                    ?>

                </p>


                <p>

                    <strong>Role:</strong>

                    <?php
                    echo htmlspecialchars($user["role"]);
                    ?>

                </p>


                <p>

                    <strong>Status:</strong>

                    <?php
                    echo htmlspecialchars($user["status"]);
                    ?>

                </p>


                <p>

                    <strong>Joined:</strong>

                    <?php
                    echo htmlspecialchars($user["created_at"]);
                    ?>

                </p>


                <?php

                // Admin cannot change own status

                if ($user["user_id"] != $_SESSION["user_id"]) {

                ?>

                    <div class="actions">


                        <a
                            href="toggle_user_status.php?id=<?php echo $user["user_id"]; ?>"
                            class="confirm-btn"
                        >

                            Change Status

                        </a>


                    </div>


                <?php

                } else {

                ?>

                    <p>
                        <strong>Current Admin Account</strong>
                    </p>

                <?php

                }

                ?>


            </div>


        <?php } ?>


    <?php } else { ?>


        <p class="no-trip">

            No users found.

        </p>


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