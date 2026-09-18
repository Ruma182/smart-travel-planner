<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Create Account</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body class="auth-page">

<div class="auth-card">

    <h1>Create Account</h1>

    <p class="muted">
        Sign up as a service provider
    </p>

    <?php if ($error): ?>

        <div class="alert danger">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>

    <form method="post" id="registerForm" novalidate>

        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($old['full_name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($old['email']) ?>" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($old['phone']) ?>">

        <label>Company Name</label>
        <input type="text" name="company_name" value="<?= htmlspecialchars($old['company_name']) ?>">

        <label>Address</label>
        <input type="text" name="address" value="<?= htmlspecialchars($old['address']) ?>">

        <label>Password</label>
        <input type="password" name="password" minlength="8" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm" minlength="8" required>

        <button
            type="submit"
            class="btn primary full"
        >
            Create Account
        </button>

    </form>

    <div class="auth-switch">
        Already have an account?
        <a href="login.php">Sign in here</a>
    </div>

</div>

<script src="assets/js/validate.js"></script>
<script>
    SPValidate.attach(document.getElementById('registerForm'), {
        full_name: [
            { required: true, message: 'Full name is required.' }
        ],
        email: [
            { required: true, message: 'Email is required.' },
            { email: true, message: 'Please enter a valid email address.' }
        ],
        password: [
            { required: true, message: 'Password is required.' },
            { minLength: 8, message: 'Password must be at least 8 characters.' }
        ],
        confirm: [
            { required: true, message: 'Please confirm your password.' },
            { match: 'password', message: 'Passwords do not match.' }
        ]
    });
</script>

</body>

</html>
