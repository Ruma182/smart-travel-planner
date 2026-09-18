<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Manage Listings</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

<div class="layout">

    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">

        <?php include __DIR__ . '/../partials/header.php'; ?>

        <section class="content">

            <div class="page-title">

                <div>

                    <h1>Manage Listings</h1>

                    <p class="muted">
                        Travel packages, hotels and transport with pricing and availability.
                    </p>

                </div>

                <a
                    class="btn primary"
                    href="add_listing.php"
                >
                    + Add Listing
                </a>

            </div>

            <?php if ($msg): ?>

                <div class="alert success">
                    <?= htmlspecialchars($msg) ?>
                </div>

            <?php endif; ?>

            <div class="grid-list">

                <?php while ($r = $rows->fetch_assoc()): ?>

                    <div class="listing-card">

                        <div class="listing-image">

                            <?php if (
                                $r['image'] &&
                                file_exists('uploads/' . $r['image'])
                            ): ?>

                                <img
                                    src="uploads/<?= htmlspecialchars($r['image']) ?>"
                                    alt="<?= htmlspecialchars($r['name']) ?>"
                                >

                            <?php else: ?>

                                <span>
                                    <?= $r['listing_type'] === 'Hotel'
                                        ? '🏨'
                                        : ($r['listing_type'] === 'Transport'
                                            ? '🚌'
                                            : '🌴') ?>
                                </span>

                            <?php endif; ?>

                        </div>

                        <div class="listing-body">

                            <span class="type">
                                <?= htmlspecialchars($r['listing_type']) ?>
                            </span>

                            <h3>
                                <?= htmlspecialchars($r['name']) ?>
                            </h3>

                            <p>
                                📍 <?= htmlspecialchars($r['destination']) ?>
                            </p>

                            <p>
                                <?= htmlspecialchars($r['description']) ?>
                            </p>

                            <div class="listing-meta">

                                <b>
                                    ৳<?= number_format($r['price'], 2) ?>
                                </b>

                                <span>
                                    Availability:
                                    <?= (int) $r['availability'] ?>
                                </span>

                            </div>

                            <div class="actions">

                                <a
                                    class="btn small"
                                    href="edit_listing.php?id=<?= $r['listing_id'] ?>"
                                >
                                    Edit
                                </a>

                                <a
                                    class="btn small danger-outline delete-listing"
                                    data-confirm="Delete this listing?"
                                    href="delete_listing.php?id=<?= $r['listing_id'] ?>"
                                >
                                    Delete
                                </a>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

        </section>

    </main>

</div>

<script src="assets/js/listings-ajax.js"></script>

</body>

</html>
