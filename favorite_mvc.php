
<?php

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/FavoriteController.php';

$controller = new FavoriteController($conn);

$action = $_GET["action"] ?? "index";

if ($action == "add") {

    $controller->add();

} elseif ($action == "delete") {

    $controller->delete();

} else {

    $controller->index();

}

?>

