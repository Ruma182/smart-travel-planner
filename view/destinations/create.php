<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Local Destination - Smart Travel Planner</title>

    <link
        rel="stylesheet"
        href="../../style.css"
    >

    <style>

        .form-container {
            width: 90%;
            max-width: 700px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-container h1 {
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group textarea {
            min-height: 130px;
            resize: vertical;
        }

        .submit-btn {
            background: #198754;
            color: white;
            border: none;
            padding: 11px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-btn {
            display: inline-block;
            margin-left: 8px;
            padding: 11px 20px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

    </style>

</head>


<body>


<div class="form-container">

    <h1>Add Local Destination</h1>

    <p>
        Add a new destination to Smart Travel Planner.
    </p>


    <form
        method="POST"
        action="/web-technology/smart-travel-planner/destination_mvc.php?action=store"
        onsubmit="return validateDestinationForm()"
    >


        <div class="form-group">

            <label for="name">
                Destination Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                placeholder="Example: Coxs Bazar"
                required
            >

        </div>


        <div class="form-group">

            <label for="location">
                Location
            </label>

            <input
                type="text"
                id="location"
                name="location"
                placeholder="Example: Chattogram, Bangladesh"
                required
            >

        </div>


        <div class="form-group">

            <label for="description">
                Description
            </label>

            <textarea
                id="description"
                name="description"
                placeholder="Write about this destination..."
                required
            ></textarea>

        </div>


        <div class="form-group">

            <label for="estimated_cost">
                Estimated Cost (BDT)
            </label>

            <input
                type="number"
                id="estimated_cost"
                name="estimated_cost"
                min="0"
                step="0.01"
                placeholder="Example: 8000"
                required
            >

        </div>


        <button
            type="submit"
            name="add_destination"
            class="submit-btn"
        >
            Add Destination
        </button>


        <a
            href="/web-technology/smart-travel-planner/local_explorer_dashboard.php"
            class="back-btn"
        >
            Back to Dashboard
        </a>


    </form>


</div>


<script>

function validateDestinationForm() {

    const name =
        document.getElementById("name").value.trim();

    const location =
        document.getElementById("location").value.trim();

    const description =
        document.getElementById("description").value.trim();

    const estimatedCost =
        document.getElementById("estimated_cost").value;


    if (name === "") {

        alert("Please enter destination name.");

        return false;
    }


    if (location === "") {

        alert("Please enter location.");

        return false;
    }


    if (description === "") {

        alert("Please enter destination description.");

        return false;
    }


    if (
        estimatedCost === "" ||
        Number(estimatedCost) < 0
    ) {

        alert("Please enter a valid estimated cost.");

        return false;
    }


    return true;
}

</script>


</body>

</html>