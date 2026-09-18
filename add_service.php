<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["role"] != "provider") {
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

    <title>Add Travel Service</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="booking-container">

        <h1>Add Travel Service</h1>

        <p>Add your hotel, transport or travel package.</p>

        <form action="save_service.php" method="POST">

            <label>Service Type</label>

            <select name="service_type" required>

                <option value="">
                    Select Service Type
                </option>

                <option value="Hotel">
                    Hotel
                </option>

                <option value="Transport">
                    Transport
                </option>

                <option value="Travel Package">
                    Travel Package
                </option>

            </select>


            <input
                type="text"
                name="service_name"
                placeholder="Service Name"
                required
            >


            <input
                type="text"
                name="location"
                placeholder="Location"
                required
            >


            <textarea
                name="description"
                placeholder="Service Description"
                required
            ></textarea>


            <input
                type="number"
                name="price"
                placeholder="Price"
                min="0"
                required
            >


            <button type="submit">
                Add Service
            </button>

        </form>


        <a href="provider_dashboard.php" class="back-btn">
            ← Back to Dashboard
        </a>

    </div>

</body>

</html>