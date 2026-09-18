<?php $title='Dashboard'; $page='dashboard'; require __DIR__.'/../layout/header.php'; ?>
<div class="app">
<?php require __DIR__.'/../layout/sidebar.php'; ?>
<main class="content">
<header class="topbar">
    <div><h1>Dashboard</h1><p class="muted">Welcome, <?= e($_SESSION['username'] ?? 'Local Explorer') ?>!</p></div>
    <div class="avatar"><?= e(strtoupper(substr($_SESSION['username'] ?? 'L',0,1))) ?></div>
</header>

<section class="hero card">
    <div>
        <h2>Local Insights<br>Make Better Journeys</h2>
        <p>Share your recommendations, tips and experiences with travelers around the world.</p>
        <div class="actions">
            <a class="btn primary" href="<?= pageUrl('recommendation') ?>">+ Add Recommendation</a>
            <a class="btn light" href="<?= pageUrl('travel_tip') ?>">+ Share Travel Tip</a>
        </div>
    </div>
    <div class="hero-mark">LE</div>
</section>

<section class="stats">
    <div class="stat"><span>Recommendations</span><strong><?= e($counts['local_recommendation']) ?></strong></div>
    <div class="stat"><span>Travel Tips</span><strong><?= e($counts['travel_tip']) ?></strong></div>
    <div class="stat"><span>Destination Info</span><strong><?= e($counts['destination_info']) ?></strong></div>
    <div class="stat"><span>Questions</span><strong><?= e($counts['question_response']) ?></strong></div>
    <div class="stat"><span>Feedback</span><strong><?= e($counts['explorer_feedback']) ?></strong></div>
</section>

<section class="feature-grid">
    <a class="feature" href="<?= pageUrl('recommendation') ?>"><h3>Local Recommendations</h3><p>Add hidden attractions, food spots, events and cultural activities.</p></a>
    <a class="feature" href="<?= pageUrl('travel_tip') ?>"><h3>Travel Tips</h3><p>Share your travel tips and local experiences.</p></a>
    <a class="feature" href="<?= pageUrl('destination_info') ?>"><h3>Destination Information</h3><p>Submit and update destination details.</p></a>
    <a class="feature" href="<?= pageUrl('question_response') ?>"><h3>Traveler Questions</h3><p>Respond to traveler questions and suggestions.</p></a>
    <a class="feature" href="<?= pageUrl('feedback') ?>"><h3>Feedback & Ratings</h3><p>See feedback and improve your recommendations.</p></a>
</section>
</main>
</div>
<?php require __DIR__.'/../layout/footer.php'; ?>
