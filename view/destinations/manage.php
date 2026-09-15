
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
        Manage Destinations - Smart Travel Planner
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


        .manage-container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
        }


        .manage-header {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }


        .manage-header h1 {
            margin-bottom: 8px;
        }


        .manage-header p {
            color: #666;
        }


        .add-btn,
        .back-btn {
            display: inline-block;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 10px;
            margin-right: 8px;
        }


        .add-btn {
            background: #198754;
            color: white;
        }


        .back-btn {
            background: #6c757d;
            color: white;
        }


        .destination-card {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }


        .destination-card h2 {
            margin-top: 0;
            color: #222;
        }


        .destination-card p {
            line-height: 1.6;
        }


        .cost {
            font-weight: bold;
            color: #198754;
        }


        .actions {
            margin-top: 15px;
        }


        .edit-btn,
        .delete-btn {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            margin-right: 8px;
        }


        .edit-btn {
            background: #0d6efd;
        }


        .delete-btn {
            background: #dc3545;
        }


        .no-data {
            background: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
        }

    </style>

</head>


<body>


<div class="manage-container">


    <div class="manage-header">


        <h1>
            Manage Local Destinations
        </h1>


        <p>
            View, edit, and remove destinations
            from the Smart Travel Planner.
        </p>


        <!-- CREATE DESTINATION -->

        <a
            href="/web-technology/smart-travel-planner/destination_mvc.php?action=create"
            class="add-btn"
        >
            + Create Destination
        </a>


        <!-- BACK TO DASHBOARD -->

        <a
            href="/web-technology/smart-travel-planner/local_explorer_dashboard.php"
            class="back-btn"
        >
            ← Back to Dashboard
        </a>


    </div>


    <?php

    if ($result && mysqli_num_rows($result) > 0) {

        while ($destination = mysqli_fetch_assoc($result)) {

    ?>


            <div class="destination-card">


                <h2>

                    <?php

                    echo htmlspecialchars(
                        $destination["name"]
                    );

                    ?>

                </h2>


                <p>

                    <strong>
                        Location:
                    </strong>

                    <?php

                    echo htmlspecialchars(
                        $destination["location"]
                    );

                    ?>

                </p>


                <p>

                    <strong>
                        Description:
                    </strong>

                    <br>

                    <?php

                    echo nl2br(
                        htmlspecialchars(
                            $destination["description"]
                        )
                    );

                    ?>

                </p>


                <p class="cost">

                    Estimated Cost:

                    ৳<?php

                    echo number_format(
                        $destination["estimated_cost"],
                        2
                    );

                    ?>

                </p>


                <p>

                    <strong>
                        Created:
                    </strong>

                    <?php

                    echo htmlspecialchars(
                        $destination["created_at"]
                    );

                    ?>

                </p>


                <div class="actions">


                    <!-- EDIT -->

                    <a
                        href="/web-technology/smart-travel-planner/destination_mvc.php?action=edit&edit=<?php echo $destination["destination_id"]; ?>"
                        class="edit-btn"
                    >
                        Edit
                    </a>


                    <!-- DELETE -->

                    <a
                        href="/web-technology/smart-travel-planner/destination_mvc.php?action=delete&delete=<?php echo $destination["destination_id"]; ?>"
                        class="delete-btn"
                        onclick="return confirm('Are you sure you want to delete this destination?');"
                    >
                        Delete
                    </a>


                </div>


            </div>


    <?php

        }

    } else {

    ?>


        <div class="no-data">


            <h2>
                No Destinations Found
            </h2>


            <p>
                There are currently no destinations available.
            </p>


            <a
                href="/web-technology/smart-travel-planner/destination_mvc.php?action=create"
                class="add-btn"
            >
                Create First Destination
            </a>


        </div>


    <?php

    }

    ?>


</div>


</body>

</html>

