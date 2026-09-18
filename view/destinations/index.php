
<?php

// DestinationController থেকে $result আসবে

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
        Explore Destinations - Smart Travel Planner
    </title>

    <link rel="stylesheet"
          href="/web-technology/smart-travel-planner/style.css">

</head>


<body>


<div class="destination-page">


    <h1>
        Explore Destinations
    </h1>


    <p>
        Search and discover amazing places
        for your next journey.
    </p>


    <input
        type="text"
        id="searchInput"
        placeholder="Search destination..."
        autocomplete="off"
    >


    <div id="destinationResults">


        <?php

        if ($result && mysqli_num_rows($result) > 0) {

            while ($destination = mysqli_fetch_assoc($result)) {

        ?>

                <div class="destination-card">

                    <h2>
                        <?php
                        echo htmlspecialchars($destination["name"]);
                        ?>
                    </h2>

                    <p>
                        <strong>Location:</strong>

                        <?php
                        echo htmlspecialchars($destination["location"]);
                        ?>
                    </p>

                    <p>
                        <?php
                        echo htmlspecialchars($destination["description"]);
                        ?>
                    </p>

                    <p>
                        <strong>Estimated Cost:</strong>

                        BDT

                        <?php
                        echo htmlspecialchars($destination["estimated_cost"]);
                        ?>
                    </p>


                    <div class="destination-actions">

                        <a
                            href="/web-technology/smart-travel-planner/favorite_mvc.php?action=add&destination=<?php echo urlencode($destination["name"]); ?>"
                            class="favorite-btn"
                        >
                            Add to Favorite
                        </a>

                    </div>

                </div>

        <?php

            }

        } else {

        ?>

            <p>
                No destinations found.
            </p>

        <?php

        }

        ?>

    </div>


    <a
        href="/web-technology/smart-travel-planner/traveler_dashboard.php"
        class="back-btn"
    >
        ← Back to Dashboard
    </a>


</div>


<script src="/web-technology/smart-travel-planner/js/search.js"></script>


<script>

    console.log("DESTINATION MVC VIEW LOADED");

</script>


</body>

</html>

