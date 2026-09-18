<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Provider Login</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body class="auth-page">

<div class="auth-card">

    <h1>Service Provider</h1>

    <p class="muted">
        Sign in to manage your services
    </p>

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

    <form method="post" id="loginForm" novalidate>

        <label>Email</label>

        <input
            type="email"
            name="email"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            required
        >

        <button
            type="submit"
            class="btn primary full"
        >
            Login
        </button>

    </form>

    <div class="auth-switch">
        Don't have an account?
        <a href="register.php">Sign up here</a>
    </div>

</div>

<script src="assets/js/validate.js"></script>
<script>
    SPValidate.attach(document.getElementById('loginForm'), {
        email: [
            { required: true, message: 'Email is required.' },
            { email: true, message: 'Please enter a valid email address.' }
        ],
        password: [
            { required: true, message: 'Password is required.' }
        ]
    });
</script>

</body>

</html>
