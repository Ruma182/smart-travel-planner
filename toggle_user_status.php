<?php

session_start();

include 'config/database.php';


if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}


if ($_SESSION["role"] != "admin") {

    header("Location: login.php");
    exit();

}


if (isset($_GET["id"])) {

    $user_id = (int) $_GET["id"];


    if ($user_id != $_SESSION["user_id"]) {


        $query = "SELECT status
                  FROM users
                  WHERE user_id = ?";


        $stmt = mysqli_prepare(
            $conn,
            $query
        );


        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $user_id
        );


        mysqli_stmt_execute($stmt);


        $result =
            mysqli_stmt_get_result($stmt);


        if ($user =
            mysqli_fetch_assoc($result)) {


            if (
                $user["status"]
                == "active"
            ) {

                $new_status =
                    "suspended";

            } else {

                $new_status =
                    "active";

            }


            $update_query =
                "UPDATE users
                 SET status = ?
                 WHERE user_id = ?";


            $update_stmt =
                mysqli_prepare(
                    $conn,
                    $update_query
                );


            mysqli_stmt_bind_param(
                $update_stmt,
                "si",
                $new_status,
                $user_id
            );


            mysqli_stmt_execute(
                $update_stmt
            );

        }

    }

}


header(
    "Location: manage_users.php"
);

exit();

?>