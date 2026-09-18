<?php

session_start();

include 'config/database.php';


// =========================
// LOGIN CHECK
// =========================

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


// =========================
// ADMIN CHECK
// =========================

if ($_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}


// =========================
// DELETE DESTINATION
// =========================

if (isset($_GET["delete"])) {

    $destination_id = intval($_GET["delete"]);

    $delete_sql = "
        DELETE FROM destinations
        WHERE destination_id = ?
    ";

    $stmt = mysqli_prepare($conn, $delete_sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $destination_id
    );

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("Location: admin_manage_destinations.php");
    exit();
}


// =========================
// UPDATE DESTINATION
// =========================

if (isset($_POST["update_destination"])) {

    $destination_id = intval($_POST["destination_id"]);

    $name = trim($_POST["name"]);

    $location = trim($_POST["location"]);

    $description = trim($_POST["description"]);

    $estimated_cost = floatval(
        $_POST["estimated_cost"]
    );


    $update_sql = "
        UPDATE destinations
        SET
            name = ?,
            location = ?,
            description = ?,
            estimated_cost = ?
        WHERE destination_id = ?
    ";


    $stmt = mysqli_prepare(
        $conn,
        $update_sql
    );


    mysqli_stmt_bind_param(
        $stmt,
        "sssdi",
        $name,
        $location,
        $description,
        $estimated_cost,
        $destination_id
    );


    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);


    header(
        "Location: admin_manage_destinations.php"
    );

    exit();
}


// =========================
// GET DESTINATIONS
// =========================

$sql = "
    SELECT
        destination_id,
        name,
        location,
        description,
        estimated_cost,
        created_at
    FROM destinations
    ORDER BY destination_id DESC
";


$result = mysqli_query(
    $conn,
    $sql
);

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
        Manage Destinations - Admin
    </title>


    <link
        rel="stylesheet"
        href="style.css"
    >


    <style>

        .admin-destination-container {

            width: 90%;
            max-width: 1100px;

            margin: 45px auto;

        }


        .admin-page-header {

            background: white;

            padding: 30px;

            border-radius: 22px;

            margin-bottom: 25px;

            box-shadow:
                0 10px 35px
                rgba(16,42,67,0.08);

        }


        .admin-page-header h1 {

            margin-bottom: 8px;

        }


        .admin-page-header p {

            color: #52606d;

            margin-bottom: 20px;

        }


        .destination-card {

            background: white;

            padding: 28px;

            margin-bottom: 22px;

            border-radius: 20px;

            border: 1px solid #e6eef1;

            box-shadow:
                0 8px 25px
                rgba(16,42,67,0.07);

        }


        .destination-card h2 {

            margin-top: 0;

            margin-bottom: 15px;

            color: #102a43;

        }


        .destination-card p {

            color: #52606d;

            line-height: 1.7;

        }


        .cost {

            color: #0b7285 !important;

            font-weight: 800;

        }


        /* =========================
           ACTION BUTTONS
        ========================= */


        .actions {

            display: flex;

            gap: 12px;

            margin-top: 22px;

            padding-top: 18px;

            border-top: 1px solid #e6eef1;

        }


        .edit-btn,
        .delete-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 90px;

            padding: 11px 18px;

            border-radius: 10px;

            color: white;

            text-decoration: none;

            font-size: 14px;

            font-weight: 700;

            border: none;

            cursor: pointer;

            transition: 0.3s;

        }


        /* BLUE EDIT */

        .edit-btn {

            background: #0d6efd;

        }


        .edit-btn:hover {

            background: #0b5ed7;

            transform: translateY(-2px);

            box-shadow:
                0 7px 18px
                rgba(13,110,253,0.25);

        }


        /* RED DELETE */

        .delete-btn {

            background: #dc3545;

        }


        .delete-btn:hover {

            background: #bb2d3b;

            transform: translateY(-2px);

            box-shadow:
                0 7px 18px
                rgba(220,53,69,0.25);

        }


        /* =========================
           EDIT FORM
        ========================= */


        .edit-form {

            margin-top: 25px;

            padding: 28px;

            background: #f7fafb;

            border: 1px solid #e2ecef;

            border-radius: 18px;

        }


        .edit-form h3 {

            margin-top: 0;

            margin-bottom: 20px;

            color: #102a43;

        }


        .edit-form label {

            display: block;

            margin-top: 13px;

            margin-bottom: 7px;

            font-weight: 700;

            color: #102a43;

        }


        .edit-form input,
        .edit-form textarea {

            width: 100%;

            padding: 13px 15px;

            box-sizing: border-box;

            border: 1px solid #dce7eb;

            border-radius: 10px;

            background: white;

            font-size: 14px;

            outline: none;

        }


        .edit-form input:focus,
        .edit-form textarea:focus {

            border-color: #20c997;

            box-shadow:
                0 0 0 4px
                rgba(32,201,151,0.10);

        }


        .edit-form textarea {

            min-height: 140px;

            resize: vertical;

            line-height: 1.6;

        }


        .edit-actions {

            display: flex;

            gap: 10px;

            margin-top: 20px;

        }


        .update-btn {

            background: #198754;

            color: white;

            border: none;

            padding: 11px 20px;

            border-radius: 10px;

            font-weight: 700;

            cursor: pointer;

        }


        .update-btn:hover {

            background: #157347;

            transform: translateY(-2px);

        }


        .cancel-btn {

            background: #6c757d;

            color: white;

            padding: 11px 20px;

            border-radius: 10px;

            text-decoration: none;

            font-weight: 700;

        }


        .cancel-btn:hover {

            background: #5c636a;

        }


        .no-data {

            background: white;

            padding: 45px;

            text-align: center;

            border-radius: 20px;

            box-shadow:
                0 8px 25px
                rgba(16,42,67,0.07);

        }


        @media (max-width: 600px) {

            .admin-destination-container {

                width: 94%;

            }


            .actions {

                flex-direction: column;

            }


            .edit-btn,
            .delete-btn {

                width: 100%;

            }


            .edit-actions {

                flex-direction: column;

            }


            .update-btn,
            .cancel-btn {

                width: 100%;

                text-align: center;

                box-sizing: border-box;

            }

        }

    </style>

</head>


<body>


<div class="admin-destination-container">


    <!-- =========================
         HEADER
    ========================== -->

    <div class="admin-page-header">

        <h1>
            Manage Destinations
        </h1>

        <p>
            View, edit, and remove destinations from the platform.
        </p>

    </div>


    <!-- =========================
         DESTINATIONS
    ========================== -->


    <?php

    if (
        $result &&
        mysqli_num_rows($result) > 0
    ) {

        while (
            $destination =
            mysqli_fetch_assoc($result)
        ) {

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

                <strong>
                    Estimated Cost:
                </strong>

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


            <!-- =========================
                 EDIT + DELETE BUTTON
            ========================== -->


            <div class="actions">


                <a
                    href="admin_manage_destinations.php?edit=<?php echo $destination["destination_id"]; ?>"
                    class="edit-btn"
                >

                    Edit

                </a>


                <a
                    href="admin_manage_destinations.php?delete=<?php echo $destination["destination_id"]; ?>"
                    class="delete-btn"

                    onclick="
                        return confirm(
                            'Are you sure you want to delete this destination?'
                        );
                    "
                >

                    Delete

                </a>


            </div>


            <!-- =========================
                 EDIT FORM
            ========================== -->


            <?php

            if (
                isset($_GET["edit"]) &&
                intval($_GET["edit"])
                ==
                $destination["destination_id"]
            ) {

            ?>


                <div class="edit-form">


                    <h3>
                        Edit Destination
                    </h3>


                    <form
                        method="POST"
                        action="admin_manage_destinations.php"
                    >


                        <input
                            type="hidden"
                            name="destination_id"
                            value="<?php
                            echo $destination["destination_id"];
                            ?>"
                        >


                        <label>
                            Destination Name
                        </label>


                        <input
                            type="text"
                            name="name"
                            value="<?php
                            echo htmlspecialchars(
                                $destination["name"]
                            );
                            ?>"
                            required
                        >


                        <label>
                            Location
                        </label>


                        <input
                            type="text"
                            name="location"
                            value="<?php
                            echo htmlspecialchars(
                                $destination["location"]
                            );
                            ?>"
                            required
                        >


                        <label>
                            Description
                        </label>


                        <textarea
                            name="description"
                            required
                        ><?php
                        echo htmlspecialchars(
                            $destination["description"]
                        );
                        ?></textarea>


                        <label>
                            Estimated Cost
                        </label>


                        <input
                            type="number"
                            name="estimated_cost"
                            step="0.01"
                            min="0"
                            value="<?php
                            echo htmlspecialchars(
                                $destination["estimated_cost"]
                            );
                            ?>"
                            required
                        >


                        <div class="edit-actions">


                            <button
                                type="submit"
                                name="update_destination"
                                class="update-btn"
                            >

                                Update Destination

                            </button>


                            <a
                                href="admin_manage_destinations.php"
                                class="cancel-btn"
                            >

                                Cancel

                            </a>


                        </div>


                    </form>


                </div>


            <?php

            }

            ?>


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


        </div>


    <?php

    }

    ?>


    <a
        href="admin_dashboard.php"
        class="back-btn"
    >

        ← Back to Admin Dashboard

    </a>


</div>


</body>

</html>