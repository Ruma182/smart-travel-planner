
<?php

// DestinationController থেকে $destination আসবে

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
        Edit Destination - Smart Travel Planner
    </title>

    <link
        rel="stylesheet"
        href="../../style.css"
    >


    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            margin: 0;
            padding: 0;
        }


        .edit-container {
            width: 90%;
            max-width: 700px;
            margin: 40px auto;
        }


        .edit-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }


        .edit-form h1 {
            margin-bottom: 10px;
        }


        .edit-form p {
            color: #666;
            margin-bottom: 25px;
        }


        .form-group {
            margin-bottom: 18px;
        }


        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }


        .edit-form input,
        .edit-form textarea {

            width: 100%;

            box-sizing: border-box;

            padding: 11px;

            border: 1px solid #ccc;

            border-radius: 5px;

            font-size: 15px;

        }


        .edit-form textarea {

            min-height: 130px;

            resize: vertical;

        }


        .update-btn {

            background: #0d6efd;

            color: white;

            border: none;

            padding: 11px 20px;

            border-radius: 5px;

            cursor: pointer;

            font-size: 15px;

        }


        .cancel-btn {

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


<div class="edit-container">


    <div class="edit-form">


        <h1>
            Edit Local Destination
        </h1>


        <p>
            Update the information of this destination.
        </p>


        <form
            method="POST"
            action="/web-technology/smart-travel-planner/destination_mvc.php?action=update"
        >


            <!-- Destination ID -->

            <input
                type="hidden"
                name="destination_id"
                value="<?php echo htmlspecialchars($destination["destination_id"]); ?>"
            >


            <!-- Destination Name -->

            <div class="form-group">

                <label for="name">
                    Destination Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?php echo htmlspecialchars($destination["name"]); ?>"
                    required
                >

            </div>


            <!-- Location -->

            <div class="form-group">

                <label for="location">
                    Location
                </label>

                <input
                    type="text"
                    id="location"
                    name="location"
                    value="<?php echo htmlspecialchars($destination["location"]); ?>"
                    required
                >

            </div>


            <!-- Description -->

            <div class="form-group">

                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    required
                ><?php echo htmlspecialchars($destination["description"]); ?></textarea>

            </div>


            <!-- Estimated Cost -->

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
                    value="<?php echo htmlspecialchars($destination["estimated_cost"]); ?>"
                    required
                >

            </div>


            <!-- Buttons -->

            <button
                type="submit"
                name="update_destination"
                class="update-btn"
            >
                Update Destination
            </button>


            <a
                href="../../destination_mvc.php?action=manage"
                class="cancel-btn"
            >
                Cancel
            </a>


        </form>


    </div>


</div>


</body>

</html>

