
<?php

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Review.php';
require_once __DIR__ . '/controllers/ReviewController.php';


$reviewModel = new Review($conn);

$reviewController = new ReviewController($reviewModel);


$action = $_GET["action"] ?? "create";


switch ($action) {

    case "create":

        $reviewController->create();

        break;


    case "store":

        $reviewController->store();

        break;


    case "my_reviews":

        $reviewController->index();

        break;


    default:

        $reviewController->create();

        break;
}

?>

