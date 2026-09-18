
<?php

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/DestinationController.php';


$controller = new DestinationController($conn);

$action = $_GET["action"] ?? "index";


if ($action == "create") {

    $controller->create();

} elseif ($action == "store") {

    $controller->store();

} elseif ($action == "search") {

    $controller->search();

} elseif ($action == "manage") {

    $controller->manage();

} elseif ($action == "edit") {

    $controller->edit();

} elseif ($action == "update") {

    $controller->update();

} elseif ($action == "delete") {

    $controller->delete();

} else {

    $controller->index();

}

?>

