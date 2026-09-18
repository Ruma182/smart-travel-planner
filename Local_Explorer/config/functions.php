<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($value) {
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}

function redirect($url) {
    header("Location: " . $url);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['explorer_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect("index.php?page=login");
    }
}

function uploadImage($file) {
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return "";
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "";
    }

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) {
        return "";
    }

    $dir = __DIR__ . "/../public/uploads/";
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $name = time() . "_" . preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME)) . "." . $ext;
    move_uploaded_file($file['tmp_name'], $dir . $name);
    return $name;
}

function pageUrl($page) {
    return "index.php?page=" . urlencode($page);
}
?>
