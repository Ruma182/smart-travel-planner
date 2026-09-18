<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

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

                    <h1>Personalized Dashboard</h1>

                    <p class="muted">
                        Manage listings, bookings, notifications and customer feedback.
                    </p>

                </div>

                <a
                    class="btn primary"
                    href="add_listing.php"
                >
                    + Add Listing
                </a>

            </div>

            <div class="stats">

                <div class="stat">
                    <span>Total Listings</span>
                    <b><?= (int) $totalListings ?></b>
                </div>

                <div class="stat">
                    <span>Available Units</span>
                    <b><?= (int) $available ?></b>
                </div>

                <div class="stat">
                    <span>Pending Bookings</span>
                    <b><?= (int) $pending ?></b>
                </div>

                <div class="stat">
                    <span>Confirmed</span>
                    <b><?= (int) $confirmed ?></b>
                </div>

                <div class="stat">
                    <span>Rejected</span>
                    <b><?= (int) $rejected ?></b>
                </div>

                <div class="stat">
                    <span>Revenue</span>
                    <b>
                        ৳<?= number_format((float) $revenue, 2) ?>
                    </b>
                </div>

                <div class="stat">
                    <span>Average Rating</span>
                    <b>
                        ★ <?= htmlspecialchars($rating) ?>
                    </b>
                </div>

                <div class="stat">
                    <span>Feedback</span>
                    <b><?= (int) $feedbackCount ?></b>
                </div>

            </div>

            <div class="card">

                <div class="card-head">

                    <h2>Recent Booking Requests</h2>

                    <a href="booking_requests.php">
                        View all
                    </a>

                </div>

                <div class="table-wrap">

                    <table>

                        <tr>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Guests</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>

                        <?php if ($rows->num_rows > 0): ?>

                            <?php while ($r = $rows->fetch_assoc()): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($r['customer_name']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($r['name']) ?>

                                        <small>
                                            (<?= htmlspecialchars($r['listing_type']) ?>)
                                        </small>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($r['booking_date']) ?>
                                    </td>

                                    <td>
                                        <?= (int) $r['guests'] ?>
                                    </td>

                                    <td>
                                        ৳<?= number_format((float) $r['total_amount'], 2) ?>
                                    </td>

                                    <td>

                                        <span class="badge <?= strtolower(htmlspecialchars($r['status'])) ?>">
                                            <?= htmlspecialchars($r['status']) ?>
                                        </span>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="6" class="muted">
                                    No booking requests found.
                                </td>

                            </tr>

                        <?php endif; ?>

                    </table>

                </div>

            </div>

        </section>

    </main>

</div>

</body>

</html>
