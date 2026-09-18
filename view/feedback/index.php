<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Feedback</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

<div class="layout">

    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">

        <?php include __DIR__ . '/../partials/header.php'; ?>

        <section class="content">

            <h1>Customer Feedback & Ratings</h1>

            <p class="muted">
                Review customer comments and reply to improve service quality.
            </p>

            <div class="feedback-list">

                <?php while ($r = $rows->fetch_assoc()): ?>

                    <div class="card feedback">

                        <div class="feedback-head">

                            <div>

                                <b>
                                    <?= htmlspecialchars($r['customer_name']) ?>
                                </b>

                                <span class="stars">
                                    <?= str_repeat('★', (int) $r['rating']) ?>
                                    <?= str_repeat('☆', 5 - (int) $r['rating']) ?>
                                </span>

                            </div>

                            <small>
                                <?= htmlspecialchars($r['name'] ?? 'Service') ?>
                            </small>

                        </div>

                        <p>
                            <?= htmlspecialchars($r['comment']) ?>
                        </p>

                        <?php if ($r['reply']): ?>

                            <div class="reply">

                                <b>Your reply:</b>

                                <?= htmlspecialchars($r['reply']) ?>

                            </div>

                        <?php endif; ?>

                        <form
                            method="post"
                            action="reply_feedback.php"
                            class="reply-form"
                        >

                            <input
                                type="hidden"
                                name="id"
                                value="<?= $r['feedback_id'] ?>"
                            >

                            <textarea
                                name="reply"
                                placeholder="Write a reply..."
                                required
                            ><?= htmlspecialchars($r['reply'] ?? '') ?></textarea>

                            <button
                                type="submit"
                                class="btn primary small"
                            >
                                Save Reply
                            </button>

                        </form>

                    </div>

                <?php endwhile; ?>

            </div>

        </section>

    </main>

</div>

<script src="assets/js/validate.js"></script>
<script>
    document.querySelectorAll('.reply-form').forEach(function (form) {
        SPValidate.attach(form, {
            reply: [
                { required: true, message: 'Reply cannot be empty.' }
            ]
        });
    });
</script>

</body>

</html>
