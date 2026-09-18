<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Edit Listing</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

<div class="layout">

    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">

        <?php include __DIR__ . '/../partials/header.php'; ?>

        <section class="content">

            <div class="card form-card">

                <h1>Edit Listing</h1>

                <?php if ($error): ?>

                    <div class="alert danger">
                        <?= htmlspecialchars($error) ?>
                    </div>

                <?php endif; ?>

                <form
                    method="post"
                    enctype="multipart/form-data"
                    class="form-grid"
                    id="editListingForm"
                    novalidate
                >

                    <div>

                        <label>Listing Type</label>

                        <select name="listing_type">

                            <option
                                <?= $item['listing_type'] == 'Travel Package' ? 'selected' : '' ?>
                            >
                                Travel Package
                            </option>

                            <option
                                <?= $item['listing_type'] == 'Hotel' ? 'selected' : '' ?>
                            >
                                Hotel
                            </option>

                            <option
                                <?= $item['listing_type'] == 'Transport' ? 'selected' : '' ?>
                            >
                                Transport
                            </option>

                        </select>

                    </div>

                    <div>

                        <label>Name</label>

                        <input
                            name="name"
                            value="<?= htmlspecialchars($item['name']) ?>"
                            required
                        >

                    </div>

                    <div>

                        <label>Destination</label>

                        <input
                            name="destination"
                            value="<?= htmlspecialchars($item['destination']) ?>"
                            required
                        >

                    </div>

                    <div>

                        <label>Price</label>

                        <input
                            type="number"
                            step="0.01"
                            name="price"
                            value="<?= $item['price'] ?>"
                            required
                        >

                    </div>

                    <div>

                        <label>Availability</label>

                        <input
                            type="number"
                            min="0"
                            name="availability"
                            value="<?= $item['availability'] ?>"
                            required
                        >

                    </div>

                    <div>

                        <label>Replace Image</label>

                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                        >

                    </div>

                    <div class="full">

                        <label>Description</label>

                        <textarea
                            name="description"
                            rows="5"
                        ><?= htmlspecialchars($item['description']) ?></textarea>

                    </div>

                    <div class="full">

                        <button
                            type="submit"
                            class="btn primary"
                        >
                            Update Listing
                        </button>

                        <a
                            class="btn"
                            href="listings.php"
                        >
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </section>

    </main>

</div>

<script src="assets/js/validate.js"></script>
<script>
    SPValidate.attach(document.getElementById('editListingForm'), {
        name: [
            { required: true, message: 'Name is required.' }
        ],
        destination: [
            { required: true, message: 'Destination is required.' }
        ],
        price: [
            { required: true, message: 'Price is required.' },
            { min: 0, message: 'Price cannot be negative.' }
        ],
        availability: [
            { required: true, message: 'Availability is required.' },
            { min: 0, message: 'Availability cannot be negative.' }
        ]
    });
</script>
<script src="assets/js/listings-ajax.js"></script>

</body>

</html>
