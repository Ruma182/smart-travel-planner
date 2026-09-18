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

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Currency Converter</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="tool-container">

        <h1>Currency Converter</h1>

        <p>Convert your travel budget.</p>

        <input
            type="number"
            id="amount"
            placeholder="Enter Amount"
            min="0"
        >


        <select id="fromCurrency">

            <option value="BDT">
                BDT - Bangladeshi Taka
            </option>

            <option value="USD">
                USD - US Dollar
            </option>

            <option value="EUR">
                EUR - Euro
            </option>

        </select>


        <select id="toCurrency">

            <option value="USD">
                USD - US Dollar
            </option>

            <option value="BDT">
                BDT - Bangladeshi Taka
            </option>

            <option value="EUR">
                EUR - Euro
            </option>

        </select>


        <button onclick="convertCurrency()">
            Convert
        </button>


        <div id="currencyResult"></div>


        <a href="traveler_dashboard.php" class="back-btn">
            ← Back to Dashboard
        </a>

    </div>

    <script src="js/currency.js"></script>

</body>

</html>