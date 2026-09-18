
<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Favorite Destinations - Smart Travel Planner</title>

<link rel="stylesheet"
      href="/web-technology/smart-travel-planner/style.css">



</head>

<body>

<div class="destination-page">

    <h1>My Favorite Destinations</h1>

    <p>Destinations you have saved as favorites.</p>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <?php while ($favorite = mysqli_fetch_assoc($result)) { ?>

            <div class="destination-card">

                <h2>
                    <?php echo htmlspecialchars($favorite["destination_name"]); ?>
                </h2>

                <p>
                    <strong>Saved on:</strong>
                    <?php echo htmlspecialchars($favorite["created_at"]); ?>
                </p>

                <a 
    href="/web-technology/smart-travel-planner/favorite_mvc.php?action=delete&favorite_id=<?php echo $favorite["favorite_id"]; ?>" 
    class="delete-btn" 
    onclick="return confirm('Are you sure you want to remove this favorite?');" 
>
    Remove Favorite 
</a>

            </div>

        <?php } ?>

    <?php } else { ?>

        <div class="no-data">

            <p>You have no favorite destinations yet.</p>

        </div>

    <?php } ?>

    <br>

    <a
        href="/web-technology/smart-travel-planner/traveler_dashboard.php"
        class="back-btn"
    >
        ← Back to Traveler Dashboard
    </a>

</div>

</body>

</html>

