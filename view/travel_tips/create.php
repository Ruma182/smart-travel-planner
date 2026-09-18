
<?php

// TravelTipController থেকে এই view load হবে

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
        Add Travel Tip - Smart Travel Planner
    </title>

    <link
        rel="stylesheet"
        href="../../style.css"
    >

</head>


<body>


<div class="travel-tips-container">


    <h1>
        Add Travel Tip
    </h1>


    <p>
        Share useful travel advice with other travelers.
    </p>


    <?php if (isset($error)) { ?>

        <div class="tip-error">

            <?php

            echo htmlspecialchars($error);

            ?>

        </div>

    <?php } ?>


    <form
        method="POST"
        action="/web-technology/smart-travel-planner/travel_tip_mvc.php?action=store"
    >


        <label for="title">

            Tip Title

        </label>


        <input
            type="text"
            id="title"
            name="title"
            placeholder="Example: Best time to visit Coxs Bazar"
            required
        >


        <label for="description">

            Travel Tip

        </label>


        <textarea
            id="description"
            name="description"
            placeholder="Write your travel tip here..."
            required
        ></textarea>


        <button type="submit">

            Add Travel Tip

        </button>


    </form>


    <a
        href="/web-technology/smart-travel-planner/local_explorer_dashboard.php"
        class="back-btn"
    >

        ← Back to Dashboard

    </a>


</div>


</body>

</html>

