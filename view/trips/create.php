<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Trip Planner</title>

    <link rel="stylesheet"
          href="/web-technology/smart-travel-planner/style.css">

</head>

<body>

    <div class="trip-container">

        <h1>Create Your Trip Plan</h1>

        <p>Plan your journey and calculate your estimated budget.</p>

        <form
            action="/web-technology/smart-travel-planner/trip_mvc.php?action=store"
            method="POST"
            onsubmit="return validateTripForm()"
        >

            <input
                type="text"
                id="destination"
                name="destination"
                placeholder="Enter destination"
                required
            >

            <label>Start Date</label>

            <input
                type="date"
                id="start_date"
                name="start_date"
                required
            >

            <label>End Date</label>

            <input
                type="date"
                id="end_date"
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

        <a
            href="/web-technology/smart-travel-planner/traveler_dashboard.php"
            class="back-btn"
        >
            ← Back to Dashboard
        </a>

    </div>


    <script src="/web-technology/smart-travel-planner/js/budget.js"></script>


    <script>

    function validateTripForm() {

        const destination =
            document.getElementById("destination").value.trim();

        const startDate =
            document.getElementById("start_date").value;

        const endDate =
            document.getElementById("end_date").value;

        const transport =
            Number(document.getElementById("transport").value);

        const hotel =
            Number(document.getElementById("hotel").value);

        const food =
            Number(document.getElementById("food").value);

        const other =
            Number(document.getElementById("other").value);


        if (destination === "") {

            alert("Please enter a destination.");

            return false;
        }


        if (startDate === "") {

            alert("Please select a start date.");

            return false;
        }


        if (endDate === "") {

            alert("Please select an end date.");

            return false;
        }


        if (endDate < startDate) {

            alert("End date cannot be before start date.");

            return false;
        }


        if (
            transport < 0 ||
            hotel < 0 ||
            food < 0 ||
            other < 0
        ) {

            alert("Costs cannot be negative.");

            return false;
        }


        return true;
    }

    </script>


</body>

</html>