<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Notifications</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

<div class="layout">

    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">

        <?php include __DIR__ . '/../partials/header.php'; ?>

        <section class="content">

            <h1>Booking Notifications</h1>

            <div class="card notification-list">

                <?php while ($r = $rows->fetch_assoc()): ?>

                    <div class="notification">

                        <div>
                            🔔
                        </div>

                        <div>

                            <b>
                                <?= htmlspecialchars($r['message']) ?>
                            </b>

                            <small>
                                <?= htmlspecialchars($r['created_at']) ?>
                            </small>

                        </div>

                    </div>

                <?php endwhile; ?>

                <?php if ($rows->num_rows === 0): ?>

                    <p class="muted">
                        No notifications yet.
                    </p>

                <?php endif; ?>

            </div>

        </section>

    </main>

</div>

</body>

</html>
