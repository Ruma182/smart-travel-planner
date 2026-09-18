<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/models/Recommendation.php';
require_once __DIR__ . '/models/TravelTip.php';
require_once __DIR__ . '/models/DestinationInfo.php';
require_once __DIR__ . '/models/QuestionResponse.php';

function jsonResponse($success, $message = '', $extra = []) {
    echo json_encode(array_merge([
        'success' => $success,
        'message' => $message
    ], $extra));
    exit;
}

if (!isLoggedIn()) {
    jsonResponse(false, 'Please login first.');
}

$explorerId = (int)$_SESSION['explorer_id'];
$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    switch ($action) {

        case 'get_config':
            $file = __DIR__ . '/data/local_explorer.json';
            $data = json_decode(file_get_contents($file), true);
            jsonResponse(true, 'Configuration loaded.', ['data' => $data]);
            break;

        case 'recommendation_create':
            $model = new Recommendation($conn);
            $ok = $model->create(
                $explorerId,
                trim($_POST['title'] ?? ''),
                trim($_POST['description'] ?? ''),
                trim($_POST['category'] ?? ''),
                trim($_POST['location'] ?? '')
            );
            jsonResponse($ok, $ok ? 'Recommendation added.' : 'Could not add recommendation.');
            break;

        case 'recommendation_update':
            $model = new Recommendation($conn);
            $ok = $model->update(
                (int)($_POST['id'] ?? 0), $explorerId,
                trim($_POST['title'] ?? ''),
                trim($_POST['description'] ?? ''),
                trim($_POST['category'] ?? ''),
                trim($_POST['location'] ?? '')
            );
            jsonResponse($ok, $ok ? 'Recommendation updated.' : 'Could not update recommendation.');
            break;

        case 'recommendation_delete':
            $model = new Recommendation($conn);
            $ok = $model->delete((int)($_POST['id'] ?? 0), $explorerId);
            jsonResponse($ok, $ok ? 'Recommendation deleted.' : 'Could not delete recommendation.');
            break;

        case 'travel_tip_create':
            $model = new TravelTip($conn);
            $ok = $model->create(
                $explorerId,
                trim($_POST['title'] ?? ''),
                trim($_POST['content'] ?? '')
            );
            jsonResponse($ok, $ok ? 'Travel tip shared.' : 'Could not share travel tip.');
            break;

        case 'travel_tip_update':
            $model = new TravelTip($conn);
            $ok = $model->update(
                (int)($_POST['id'] ?? 0), $explorerId,
                trim($_POST['title'] ?? ''),
                trim($_POST['content'] ?? '')
            );
            jsonResponse($ok, $ok ? 'Travel tip updated.' : 'Could not update travel tip.');
            break;

        case 'travel_tip_delete':
            $model = new TravelTip($conn);
            $ok = $model->delete((int)($_POST['id'] ?? 0), $explorerId);
            jsonResponse($ok, $ok ? 'Travel tip deleted.' : 'Could not delete travel tip.');
            break;

        case 'destination_create':
            $model = new DestinationInfo($conn);
            $photo = trim($_POST['photos'] ?? '');

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploaded = uploadImage($_FILES['photo']);
                if ($uploaded !== '') {
                    $photo = $uploaded;
                }
            }

            $ok = $model->create(
                $explorerId,
                (int)($_POST['destination_id'] ?? 0),
                trim($_POST['description'] ?? ''),
                $photo,
                trim($_POST['visiting_guidelines'] ?? ''),
                trim($_POST['recommended_activities'] ?? '')
            );
            jsonResponse($ok, $ok ? 'Destination information saved.' : 'Could not save destination information.');
            break;

        case 'destination_update':
            $model = new DestinationInfo($conn);
            $photo = trim($_POST['photos'] ?? '');

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploaded = uploadImage($_FILES['photo']);
                if ($uploaded !== '') {
                    $photo = $uploaded;
                }
            }

            $ok = $model->update(
                (int)($_POST['id'] ?? 0),
                $explorerId,
                (int)($_POST['destination_id'] ?? 0),
                trim($_POST['description'] ?? ''),
                $photo,
                trim($_POST['visiting_guidelines'] ?? ''),
                trim($_POST['recommended_activities'] ?? '')
            );
            jsonResponse($ok, $ok ? 'Destination information updated.' : 'Could not update destination information.');
            break;

        case 'destination_delete':
            $model = new DestinationInfo($conn);
            $ok = $model->delete((int)($_POST['id'] ?? 0), $explorerId);
            jsonResponse($ok, $ok ? 'Destination information deleted.' : 'Could not delete destination information.');
            break;

        case 'question_update':
            $model = new QuestionResponse($conn);
            $ok = $model->updateResponse(
                (int)($_POST['id'] ?? 0),
                $explorerId,
                trim($_POST['response'] ?? '')
            );
            jsonResponse($ok, $ok ? 'Response saved.' : 'Could not save response.');
            break;

        default:
            jsonResponse(false, 'Unknown AJAX action.');
    }
} catch (Throwable $e) {
    jsonResponse(false, 'Something went wrong. Please try again.');
}
?>
