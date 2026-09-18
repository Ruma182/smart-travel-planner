<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>My Profile</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

<div class="layout">

    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">

        <?php include __DIR__ . '/../partials/header.php'; ?>

        <section class="content">

            <div class="card form-card">

                <h1>Manage Profile</h1>

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

                <form method="post" class="form-grid" id="profileForm" novalidate>

                    <div>

                        <label>Full Name</label>

                        <input
                            name="full_name"
                            value="<?= htmlspecialchars($p['full_name']) ?>"
                            required
                        >

                    </div>

                    <div>

                        <label>Email</label>

                        <input
                            value="<?= htmlspecialchars($p['email']) ?>"
                            disabled
                        >

                    </div>

                    <div>

                        <label>Phone</label>

                        <input
                            name="phone"
                            value="<?= htmlspecialchars($p['phone'] ?? '') ?>"
                        >

                    </div>

                    <div>

                        <label>Company</label>

                        <input
                            name="company_name"
                            value="<?= htmlspecialchars($p['company_name'] ?? '') ?>"
                        >

                    </div>

                    <div class="full">

                        <label>Address</label>

                        <input
                            name="address"
                            value="<?= htmlspecialchars($p['address'] ?? '') ?>"
                        >

                    </div>

                    <div class="full">

                        <button
                            type="submit"
                            class="btn primary"
                        >
                            Update Profile
                        </button>

                        <a
                            class="btn danger-outline"
                            href="delete_account.php"
                            onclick="return confirm('Delete your provider account permanently?')"
                        >
                            Delete Account
                        </a>

                    </div>

                </form>

            </div>

        </section>

    </main>

</div>

<script src="assets/js/validate.js"></script>
<script>
    SPValidate.attach(document.getElementById('profileForm'), {
        full_name: [
            { required: true, message: 'Full name is required.' }
        ]
    });
</script>

</body>

</html>
