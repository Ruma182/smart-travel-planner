
<?php

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/TripPlanController.php';

$controller = new TripPlanController($conn);

$action = $_GET["action"] ?? "create";


if ($action == "store") {

    $controller->store();

} elseif ($action == "my_trips") {

    $controller->index();

} else {

    $controller->create();

}

?>

