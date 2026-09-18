<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/RecommendationController.php';
require_once __DIR__ . '/controllers/TravelTipController.php';
require_once __DIR__ . '/controllers/DestinationInfoController.php';
require_once __DIR__ . '/controllers/QuestionResponseController.php';
require_once __DIR__ . '/controllers/FeedbackController.php';

$page = $_GET['page'] ?? (isLoggedIn() ? 'dashboard' : 'login');
switch ($page) {
    case 'login': (new AuthController($conn))->login(); break;
    case 'register': (new AuthController($conn))->register(); break;
    case 'logout': (new AuthController($conn))->logout(); break;
    case 'dashboard': (new DashboardController($conn))->index(); break;
    case 'recommendation': (new RecommendationController($conn))->index(); break;
    case 'travel_tip': (new TravelTipController($conn))->index(); break;
    case 'destination_info': (new DestinationInfoController($conn))->index(); break;
    case 'question_response': (new QuestionResponseController($conn))->index(); break;
    case 'feedback': (new FeedbackController($conn))->index(); break;
    default: redirect(pageUrl(isLoggedIn() ? 'dashboard' : 'login'));
}
?>
