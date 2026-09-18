<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Change Password</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

<div class="layout">

    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">

        <?php include __DIR__ . '/../partials/header.php'; ?>

        <section class="content">

            <div class="card form-card narrow">

                <h1>Change Password</h1>

                <?php if ($error): ?>

                    <div class="alert danger">
                        <?= htmlspecialchars($error) ?>
                    </div>

                <?php endif; ?>

                <?php if ($msg): ?>

                    <div class="alert success">
                        <?= htmlspecialchars($msg) ?>
                    </div>

                <?php endif; ?>

                <form method="post" id="changePasswordForm" novalidate>

                    <label for="current">
                        Current Password
                    </label>

                    <input
                        type="password"
                        id="current"
                        name="current"
                        required
                    >

                    <label for="new">
                        New Password
                    </label>

                    <input
                        type="password"
                        id="new"
                        name="new"
                        minlength="8"
                        required
                    >

                    <label for="confirm">
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        id="confirm"
                        name="confirm"
                        minlength="8"
                        required
                    >

                    <button
                        type="submit"
                        class="btn primary"
                    >
                        Change Password
                    </button>

                </form>

            </div>

        </section>

    </main>

</div>

<script src="assets/js/validate.js"></script>
<script>
    SPValidate.attach(document.getElementById('changePasswordForm'), {
        current: [
            { required: true, message: 'Current password is required.' }
        ],
        new: [
            { required: true, message: 'New password is required.' },
            { minLength: 8, message: 'New password must be at least 8 characters.' }
        ],
        confirm: [
            { required: true, message: 'Please confirm your new password.' },
            { match: 'new', message: 'New passwords do not match.' }
        ]
    });
</script>

</body>

</html>
