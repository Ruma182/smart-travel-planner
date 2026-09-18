
<?php

include '../config/database.php';


// ==============================
// GET SEARCH TEXT
// ==============================

$search = "";

if (isset($_GET["search"])) {

    $search = trim($_GET["search"]);

}


// ==============================
// SEARCH DESTINATIONS
// ==============================

$query = "
    SELECT
        destination_id,
        name,
        location,
        description,
        estimated_cost
    FROM destinations
    WHERE name LIKE ?
       OR location LIKE ?
    ORDER BY destination_id DESC
";


$stmt = mysqli_prepare(
    $conn,
    $query
);


$searchValue = "%" . $search . "%";


mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $searchValue,
    $searchValue
);


mysqli_stmt_execute($stmt);


$result =
    mysqli_stmt_get_result($stmt);


// ==============================
// CREATE ARRAY
// ==============================

$destinations = [];


while (
    $row = mysqli_fetch_assoc($result)
) {

    $destinations[] = [

        "destination_id" =>
            $row["destination_id"],

        "name" =>
            $row["name"],

        "location" =>
            $row["location"],

        "description" =>
            $row["description"],

        "estimated_cost" =>
            $row["estimated_cost"]

    ];

}


// ==============================
// JSON RESPONSE
// ==============================

header(
    "Content-Type: application/json"
);

echo json_encode($destinations);

?>

