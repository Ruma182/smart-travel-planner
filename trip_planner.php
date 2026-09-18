<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["role"] != "traveler") {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Trip Planner</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="trip-container">

        <h1>Create Your Trip Plan</h1>

        <p>Plan your journey and calculate your estimated budget.</p>

        <form action="save_trip.php" method="POST">

            <input
                type="text"
                name="destination"
                placeholder="Enter destination"
                required
            >

            <label>Start Date</label>

            <input
                type="date"
                name="start_date"
                required
            >

            <label>End Date</label>

            <input
                type="date"
                name="end_date"
                required
            >

            <input
                type="number"
                id="transport"
                name="transport"
                placeholder="Transport Cost"
                min="0"
                required
            >

            <input
                type="number"
                id="hotel"
                name="hotel"
                placeholder="Hotel Cost"
                min="0"
                required
            >

            <input
                type="number"
                id="food"
                name="food"
                placeholder="Food Cost"
                min="0"
                required
            >

            <input
                type="number"
                id="other"
                name="other"
                placeholder="Other Expenses"
                min="0"
                value="0"
            >

            <div class="budget-box">

                <h2>
                    Total Estimated Budget:
                    <span id="totalBudget">৳0</span>
                </h2>

            </div>

            <input
                type="hidden"
                id="total_budget"
                name="total_budget"
                value="0"
            >

            <button type="submit">
                Save Trip Plan
            </button>

        </form>

        <a href="traveler_dashboard.php" class="back-btn">
            ← Back to Dashboard
        </a>

    </div>

    <script src="js/budget.js"></script>

</body>
</html>