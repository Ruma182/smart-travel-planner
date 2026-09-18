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


$user_id = $_SESSION["user_id"];


$query = "SELECT * FROM favorites

          WHERE user_id = ?

          ORDER BY favorite_id DESC";


$stmt = mysqli_prepare(
    $conn,
    $query
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);


mysqli_stmt_execute($stmt);


$result =
    mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Favorite Destinations</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>


<body>


<div class="my-trips-container">

    <h1>My Favorite Destinations</h1>

    <p>
        Your saved travel destinations.
    </p>


    <?php if (mysqli_num_rows($result) > 0) { ?>


        <?php while ($favorite =
            mysqli_fetch_assoc($result)) { ?>


            <div class="trip-card">

                <h2>

                    <?php

                    echo htmlspecialchars(
                        $favorite["destination_name"]
                    );

                    ?>

                </h2>


                <p>

                    Added to favorites.

                </p>


                <a
                    href="remove_favorite.php?id=<?php
                    echo $favorite["favorite_id"];
                    ?>"
                    class="reject-btn"
                >

                    Remove

                </a>


            </div>


        <?php } ?>


    <?php } else { ?>


        <p class="no-trip">

            You have not added any favorite
            destination yet.

        </p>


    <?php } ?>


    <a
        href="destinations.php"
        class="create-trip-btn"
    >

        Search Destinations

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