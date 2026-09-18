<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Currency Converter</title>

    <link rel="stylesheet"
          href="/web-technology/smart-travel-planner/style.css">

</head>


<body>


<div class="tool-container">


    <h1>Currency Converter</h1>


    <p>
        Convert your travel budget.
    </p>


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


    <a
        href="/web-technology/smart-travel-planner/traveler_dashboard.php"
        class="back-btn"
    >
        ← Back to Dashboard
    </a>


</div>


<script src="/web-technology/smart-travel-planner/js/currency.js"></script>


</body>

</html>