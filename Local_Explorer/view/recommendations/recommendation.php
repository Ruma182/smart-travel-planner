<?php $title='Local Recommendations'; $page='recommendation'; require __DIR__.'/../layout/header.php'; ?>
<div class="app">
<?php require __DIR__.'/../layout/sidebar.php'; ?>
<main class="content">
<header class="topbar">
    <div><h1>Local Recommendations</h1><p class="muted">Share hidden attractions, local places, food spots, events and cultural activities.</p></div>
    <div class="avatar"><?= e(strtoupper(substr($_SESSION['username'] ?? 'L',0,1))) ?></div>
</header>

<div class="split">
<section class="card form-card">
    <h2>Add New Recommendation</h2>
    <form class="ajax-form" method="post">
        <input type="hidden" name="action" value="recommendation_create">
        <label>Title</label>
        <input name="title" placeholder="e.g. Hidden Waterfall" required>
        <label>Description</label>
        <textarea name="description" placeholder="Tell travelers about this place..." required></textarea>
        <div class="two">
            <div><label>Location</label><input name="location" placeholder="e.g. Chittagong"></div>
            <div><label>Category</label><select id="recommendation-category" name="category"><option value="">Select Category</option></select></div>
        </div>
        <button class="btn primary">Submit</button>
    </form>
</section>

<section class="card">
    <h2>My Recommendations</h2>
    <?php if(!$items): ?><p class="muted">No recommendations yet.</p><?php endif; ?>

    <?php foreach($items as $item): ?>
    <div class="item">
        <div class="item-row">
            <div class="item-body">
                <h3><?= e($item['title']) ?></h3>
                <span class="tag"><?= e($item['category'] ?: 'Local Place') ?></span>
                <p><?= nl2br(e($item['description'])) ?></p>
                <div class="meta"><?= e($item['location'] ?: 'Location not provided') ?></div>
            </div>
            <div class="item-actions">
                <button type="button" class="btn light small edit-toggle">Edit</button>
                <form class="ajax-form" method="post" data-confirm="Delete this recommendation?">
                    <input type="hidden" name="action" value="recommendation_delete">
                    <input type="hidden" name="id" value="<?= e($item['recommendation_id']) ?>">
                    <button class="btn danger small">Delete</button>
                </form>
            </div>
        </div>

        <form class="edit-form ajax-form" method="post">
            <input type="hidden" name="action" value="recommendation_update">
            <input type="hidden" name="id" value="<?= e($item['recommendation_id']) ?>">
            <div class="two">
                <div><label>Title</label><input name="title" value="<?= e($item['title']) ?>" required></div>
                <div><label>Location</label><input name="location" value="<?= e($item['location']) ?>"></div>
            </div>
            <label>Description</label><textarea name="description" required><?= e($item['description']) ?></textarea>
            <label>Category</label><input name="category" value="<?= e($item['category']) ?>">
            <button class="btn primary">Save Changes</button>
        </form>
    </div>
    <?php endforeach; ?>
</section>
</div>
</main>
</div>
<?php require __DIR__.'/../layout/footer.php'; ?>
