<?php $title='Traveler Questions'; $page='question_response'; require __DIR__.'/../layout/header.php'; ?>
<div class="app">
<?php require __DIR__.'/../layout/sidebar.php'; ?>
<main class="content">
<header class="topbar">
    <div><h1>Traveler Questions</h1><p class="muted">Answer traveler questions, share suggestions and provide useful local information.</p></div>
    <div class="avatar"><?= e(strtoupper(substr($_SESSION['username'] ?? 'L',0,1))) ?></div>
</header>

<section class="card">
    <h2>Questions from Travelers</h2>
    <?php if(!$items): ?><p class="muted">No traveler questions yet.</p><?php endif; ?>

    <?php foreach($items as $item): ?>
    <div class="question">
        <div class="question-head">
            <span class="traveler">Traveler #<?= e($item['traveler_id']) ?></span>
            <span class="date"><?= e(date('d M Y', strtotime($item['created_at']))) ?></span>
        </div>
        <div class="question-text"><?= e($item['question']) ?></div>
        <form class="ajax-form" method="post">
            <input type="hidden" name="action" value="question_update">
            <input type="hidden" name="id" value="<?= e($item['response_id']) ?>">
            <label>Your Response</label>
            <textarea name="response" rows="3" placeholder="Write your response..."><?= e($item['response']) ?></textarea>
            <button class="btn primary">Save Response</button>
        </form>
    </div>
    <?php endforeach; ?>
</section>
</main>
</div>
<?php require __DIR__.'/../layout/footer.php'; ?>
