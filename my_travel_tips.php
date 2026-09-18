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
// CREATE TABLE
// =========================

$create_table = "CREATE TABLE IF NOT EXISTS travel_tips (
    tip_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    title VARCHAR(150) NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!mysqli_query($conn, $create_table)) {

    die("Table creation failed: " . mysqli_error($conn));

}


// =========================
// CHECK REQUIRED COLUMNS
// =========================

// user_id
$check = mysqli_query(
    $conn,
    "SHOW COLUMNS FROM travel_tips LIKE 'user_id'"
);

if (mysqli_num_rows($check) == 0) {

    mysqli_query(
        $conn,
        "ALTER TABLE travel_tips
         ADD COLUMN user_id INT NULL AFTER tip_id"
    );

}


// title
$check = mysqli_query(
    $conn,
    "SHOW COLUMNS FROM travel_tips LIKE 'title'"
);

if (mysqli_num_rows($check) == 0) {

    mysqli_query(
        $conn,
        "ALTER TABLE travel_tips
         ADD COLUMN title VARCHAR(150) NULL"
    );

}


// description
$check = mysqli_query(
    $conn,
    "SHOW COLUMNS FROM travel_tips LIKE 'description'"
);

if (mysqli_num_rows($check) == 0) {

    mysqli_query(
        $conn,
        "ALTER TABLE travel_tips
         ADD COLUMN description TEXT NULL"
    );

}


// created_at
$check = mysqli_query(
    $conn,
    "SHOW COLUMNS FROM travel_tips LIKE 'created_at'"
);

if (mysqli_num_rows($check) == 0) {

    mysqli_query(
        $conn,
        "ALTER TABLE travel_tips
         ADD COLUMN created_at
         TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
    );

}


// =========================
// GET MY TRAVEL TIPS
// =========================

$user_id = $_SESSION["user_id"];

$sql = "SELECT *
        FROM travel_tips
        WHERE user_id = ?
        ORDER BY created_at DESC";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
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

    <title>My Travel Tips - Smart Travel Planner</title>

    <link rel="stylesheet" href="style.css">

</head>


<body>


<div class="travel-tips-container">


    <h1>My Travel Tips</h1>

    <p>
        View and manage the travel tips you have added.
    </p>


    <?php

    if (mysqli_num_rows($result) > 0) {

        while ($tip = mysqli_fetch_assoc($result)) {

    ?>


        <div class="travel-tip-card">


            <h2>
                <?php
                echo htmlspecialchars($tip["title"]);
                ?>
            </h2>


            <p>
                <?php
                echo nl2br(
                    htmlspecialchars($tip["description"])
                );
                ?>
            </p>


            <p class="travel-tip-date">

                Added on:

                <?php
                echo htmlspecialchars($tip["created_at"]);
                ?>

            </p>


            <a
                href="edit_travel_tip.php?id=<?php echo $tip["tip_id"]; ?>"
                class="tip-edit-btn"
            >
                Edit
            </a>


            <a
                href="delete_travel_tip.php?id=<?php echo $tip["tip_id"]; ?>"
                class="tip-delete-btn"
                onclick="return confirm('Are you sure you want to delete this travel tip?');"
            >
                Delete
            </a>


        </div>


    <?php

        }

    } else {

    ?>

        <p class="no-trip">
            You have not added any travel tips yet.
        </p>

    <?php

    }

    ?>


    <a href="travel_tips.php"
       class="create-trip-btn">

        + Add New Travel Tip

    </a>


    <br>


    <a href="local_explorer_dashboard.php"
       class="back-btn">

        ← Back to Dashboard

    </a>


</div>


</body>

</html>

<?php

mysqli_stmt_close($stmt);

?>