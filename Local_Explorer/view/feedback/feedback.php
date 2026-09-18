<?php $title='Feedback & Ratings'; $page='feedback'; require __DIR__.'/../layout/header.php'; ?>
<div class="app">
<?php require __DIR__.'/../layout/sidebar.php'; ?>
<main class="content">
<header class="topbar">
    <div><h1>Feedback & Ratings</h1><p class="muted">Receive feedback and ratings from travelers and improve the quality of your recommendations.</p></div>
    <div class="avatar"><?= e(strtoupper(substr($_SESSION['username'] ?? 'L',0,1))) ?></div>
</header>

<section class="feedback-stats">
    <div class="feedback-stat">
        <span>Average Rating</span>
        <strong><?= $summary['avg_rating'] ? number_format($summary['avg_rating'],1) : '0.0' ?> <small>/ 5</small></strong>
        <div class="rating"><?= str_repeat('★', round((float)($summary['avg_rating'] ?? 0))) ?><?= str_repeat('☆', 5-round((float)($summary['avg_rating'] ?? 0))) ?></div>
    </div>
    <div class="feedback-stat">
        <span>Total Feedback</span>
        <strong><?= e($summary['total']) ?></strong>
        <span>from travelers</span>
    </div>
</section>

<section class="card">
    <h2>Recent Feedback</h2>
    <?php foreach($items as $item): ?>
    <div class="feedback-row">
        <div class="feedback-avatar">T</div>
        <div class="feedback-body">
            <div class="feedback-top">
                <strong>Traveler #<?= e($item['traveler_id']) ?></strong>
                <div class="rating"><?= str_repeat('★',(int)$item['rating']) ?><?= str_repeat('☆',5-(int)$item['rating']) ?></div>
            </div>
            <small class="date"><?= e(date('d M Y', strtotime($item['created_at']))) ?></small>
            <p><?= nl2br(e($item['comment'] ?: 'No comment provided.')) ?></p>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if(!$items): ?><p class="muted">No feedback received yet.</p><?php endif; ?>
</section>
</main>
</div>
<?php require __DIR__.'/../layout/footer.php'; ?>
