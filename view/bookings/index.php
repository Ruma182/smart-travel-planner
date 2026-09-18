<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Requests</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

<div class="layout">

    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">

        <?php include __DIR__ . '/../partials/header.php'; ?>

        <section class="content">

            <h1>Booking Requests</h1>

            <p class="muted">
                View, confirm or reject incoming customer bookings.
            </p>

            <div class="card table-wrap">

                <table>

                    <tr>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Guests</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    <?php while ($r = $rows->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($r['customer_name']) ?>

                                <br>

                                <small>
                                    <?= htmlspecialchars($r['customer_email']) ?>
                                </small>
                            </td>

                            <td>
                                <?= htmlspecialchars($r['name']) ?>

                                <br>

                                <small>
                                    <?= htmlspecialchars($r['listing_type']) ?>
                                </small>
                            </td>

                            <td>
                                <?= htmlspecialchars($r['booking_date']) ?>
                            </td>

                            <td>
                                <?= (int) $r['guests'] ?>
                            </td>

                            <td>
                                ৳<?= number_format($r['total_amount'], 2) ?>
                            </td>

                            <td>

                                <span class="badge <?= strtolower($r['status']) ?>">
                                    <?= htmlspecialchars($r['status']) ?>
                                </span>

                            </td>

                            <td>

                                <?php if ($r['status'] === 'Pending'): ?>

                                    <a
                                        class="btn small success"
                                        href="booking_action.php?id=<?= (int) $r['booking_id'] ?>&action=confirm"
                                    >
                                        Confirm
                                    </a>

                                    <a
                                        class="btn small danger-outline"
                                        href="booking_action.php?id=<?= (int) $r['booking_id'] ?>&action=reject"
                                    >
                                        Reject
                                    </a>

                                <?php else: ?>

                                    <span class="muted">
                                        Processed
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                </table>

            </div>

        </section>

    </main>

</div>

</body>

</html>
