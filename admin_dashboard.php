
<?php

session_start();


// =========================
// LOGIN CHECK
// =========================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


// =========================
// ADMIN ROLE CHECK
// =========================

if ($_SESSION["role"] !== "admin") {

    header("Location: login.php");
    exit();

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Admin Dashboard - Smart Travel Planner
    </title>

    <link rel="stylesheet" 
      href="/web-technology/smart-travel-planner/style.css">

</head>


<body>


<div class="dashboard">


    <h1>
        Admin Dashboard
    </h1>


    <h2>

        Welcome,

        <?php

        echo htmlspecialchars(
            $_SESSION["user_name"]
        );

        ?>

    </h2>


    <div class="dashboard-links">


        <a href="/web-technology/smart-travel-planner/admin_mvc.php?action=users">
            Manage Users
        </a>


        <a href="/web-technology/smart-travel-planner/admin_mvc.php?action=destinations">
            Manage Destinations
        </a>


        <a href="/web-technology/smart-travel-planner/admin_mvc.php?action=services">
            Manage Services
        </a>


        <a href="/web-technology/smart-travel-planner/admin_mvc.php?action=bookings">
            View All Bookings
        </a>


        <a href="/web-technology/smart-travel-planner/admin_mvc.php?action=reviews">
            Manage Reviews
        </a>


        <a href="/web-technology/smart-travel-planner/admin_mvc.php?action=reports">
            Reports & Analytics
        </a>


        <a href="logout.php">
            Logout
        </a>


    </div>


</div>


</body>

</html>

