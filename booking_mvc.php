<?php

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/BookingController.php';

$controller = new BookingController($conn);

$action = $_GET["action"] ?? "create";

if ($action == "store") {

    $controller->store();

} elseif ($action == "my_bookings") {

    $controller->index();

} else {

    $controller->create();

}

?>