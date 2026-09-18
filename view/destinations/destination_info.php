<?php $title='Destination Information'; $page='destination_info'; require __DIR__.'/../layout/header.php'; ?>
<div class="app">
<?php require __DIR__.'/../layout/sidebar.php'; ?>
<main class="content">
<header class="topbar">
    <div><h1>Destination Information</h1><p class="muted">Submit and update destination information including descriptions, photos, visiting guidelines and recommended activities.</p></div>
    <div class="avatar"><?= e(strtoupper(substr($_SESSION['username'] ?? 'L',0,1))) ?></div>
</header>

<section class="card">
    <h2>Add Destination Information</h2>
    <form class="ajax-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="destination_create">
        <div class="two">
            <div><label>Destination ID</label><input type="number" name="destination_id" value="0" min="0"></div>
            <div><label>Photo</label><input type="file" name="photo" accept="image/jpeg,image/png,image/webp"></div>
        </div>
        <div class="two">
            <div><label>Description</label><textarea name="description" placeholder="Describe the destination..." required></textarea></div>
            <div><label>Visiting Guidelines</label><textarea name="visiting_guidelines" placeholder="e.g. Best time to visit, what to bring..."></textarea></div>
        </div>
        <label>Recommended Activities</label>
        <textarea name="recommended_activities" placeholder="e.g. Hiking, photography, local food..."></textarea>
        <button class="btn primary">Submit</button>
    </form>
</section>

<section class="card">
    <h2>My Destination Information</h2>
    <?php foreach($items as $item): ?>
    <div class="item destination-item">
        <div class="item-row">
            <?php if(!empty($item['photos'])): ?>
                <img class="photo-thumb" src="public/uploads/<?= e($item['photos']) ?>" alt="">
            <?php else: ?>
                <img class="photo-thumb" src="public/uploads/1789325651_waterfall_1_0_1_jpeg.webp" alt="">
            <?php endif; ?>
            <div class="item-body">
                <h3>Destination #<?= e($item['destination_id']) ?></h3>
                <p><?= nl2br(e($item['description'])) ?></p>
                <small>Created on <?= e(date('d M Y', strtotime($item['created_at']))) ?></small>
            </div>
            <div class="item-actions">
                <button type="button" class="btn light small edit-toggle">Edit</button>
                <form class="ajax-form" method="post" data-confirm="Delete this destination information?">
                    <input type="hidden" name="action" value="destination_delete">
                    <input type="hidden" name="id" value="<?= e($item['info_id']) ?>">
                    <button class="btn danger small">Delete</button>
                </form>
            </div>
        </div>

        <div class="muted" style="margin-top:8px"><b>Guidelines:</b> <?= nl2br(e($item['visiting_guidelines'] ?: 'Not provided')) ?></div>
        <div class="muted" style="margin-top:5px"><b>Activities:</b> <?= nl2br(e($item['recommended_activities'] ?: 'Not provided')) ?></div>

        <form class="edit-form ajax-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="destination_update">
            <input type="hidden" name="id" value="<?= e($item['info_id']) ?>">
            <input type="hidden" name="photos" value="<?= e($item['photos']) ?>">
            <div class="two">
                <div><label>Destination ID</label><input type="number" name="destination_id" value="<?= e($item['destination_id']) ?>" min="0"></div>
                <div><label>New Photo</label><input type="file" name="photo" accept="image/jpeg,image/png,image/webp"></div>
            </div>
            <label>Description</label><textarea name="description" required><?= e($item['description']) ?></textarea>
            <label>Visiting Guidelines</label><textarea name="visiting_guidelines"><?= e($item['visiting_guidelines']) ?></textarea>
            <label>Recommended Activities</label><textarea name="recommended_activities"><?= e($item['recommended_activities']) ?></textarea>
            <button class="btn primary">Save Changes</button>
        </form>
    </div>
    <?php endforeach; if(!$items): ?><p class="muted">No destination information submitted yet.</p><?php endif; ?>
</section>
</main>
</div>
<?php require __DIR__.'/../layout/footer.php'; ?>
