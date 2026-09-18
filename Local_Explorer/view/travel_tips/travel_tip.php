<?php $title='Travel Tips & Experiences'; $page='travel_tip'; require __DIR__.'/../layout/header.php'; ?>
<div class="app">
<?php require __DIR__.'/../layout/sidebar.php'; ?>
<main class="content">
<header class="topbar">
    <div><h1>Travel Tips & Experiences</h1><p class="muted">Share useful local tips and experiences to help travelers discover authentic destinations.</p></div>
    <div class="avatar"><?= e(strtoupper(substr($_SESSION['username'] ?? 'L',0,1))) ?></div>
</header>

<div class="split">
<section class="card form-card">
    <h2>Share a Travel Tip</h2>
    <form class="ajax-form" method="post">
        <input type="hidden" name="action" value="travel_tip_create">
        <label>Tip / Experience</label>
        <input name="title" placeholder="e.g. Best time to visit this area" required>
        <label>Content</label>
        <textarea name="content" rows="7" placeholder="Write your travel tip or experience..." required></textarea>
        <button class="btn primary">Submit</button>
    </form>
</section>

<section class="card">
    <h2>My Travel Tips</h2>
    <?php foreach($items as $item): ?>
    <div class="item">
        <div class="item-row">
            <img class="photo-thumb" src="public/uploads/1789325651_waterfall_1_0_1_jpeg.webp" alt="">
            <div class="item-body">
                <h3><?= e($item['title']) ?></h3>
                <p><?= nl2br(e($item['content'])) ?></p>
                <small>Created on <?= e(date('d M Y', strtotime($item['created_at']))) ?></small>
            </div>
            <div class="item-actions">
                <button type="button" class="btn light small edit-toggle">Edit</button>
                <form class="ajax-form" method="post" data-confirm="Delete this travel tip?">
                    <input type="hidden" name="action" value="travel_tip_delete">
                    <input type="hidden" name="id" value="<?= e($item['tip_id']) ?>">
                    <button class="btn danger small">Delete</button>
                </form>
            </div>
        </div>
        <form class="edit-form ajax-form" method="post">
            <input type="hidden" name="action" value="travel_tip_update">
            <input type="hidden" name="id" value="<?= e($item['tip_id']) ?>">
            <label>Tip / Experience</label>
            <input name="title" value="<?= e($item['title']) ?>" required>
            <label>Content</label>
            <textarea name="content" rows="5" required><?= e($item['content']) ?></textarea>
            <button class="btn primary">Save Changes</button>
        </form>
    </div>
    <?php endforeach; if(!$items): ?><p class="muted">No travel tips yet.</p><?php endif; ?>
</section>
</div>
</main>
</div>
<?php require __DIR__.'/../layout/footer.php'; ?>
