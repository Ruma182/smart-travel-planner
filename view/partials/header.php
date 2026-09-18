<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="topbar">
    <div>
        <strong>Service Provider Panel</strong>
    </div>
    <div class="top-actions">
        <a href="notifications.php">🔔 Notifications</a>
        <a href="profile.php">👤 <?= htmlspecialchars($_SESSION['provider_name'] ?? 'Provider') ?></a>
    </div>
</header>
