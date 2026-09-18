<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Listing</title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="layout">

    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">

        <?php include __DIR__ . '/../partials/header.php'; ?>

        <section class="content">

            <div class="card form-card">

                <h1>Add New Listing</h1>

                <?php if ($error): ?>

                    <div class="alert danger">
                        <?= htmlspecialchars($error) ?>
                    </div>

                <?php endif; ?>

                <form
                    method="post"
                    enctype="multipart/form-data"
                    class="form-grid"
                    id="addListingForm"
                    novalidate
                >

                    <div>
                        <label>Listing Type</label>

                        <select name="listing_type" required>
                            <option value="Travel Package">
                                Travel Package
                            </option>

                            <option value="Hotel">
                                Hotel
                            </option>

                            <option value="Transport">
                                Transport
                            </option>
                        </select>
                    </div>

                    <div>
                        <label>Name</label>

                        <input
                            type="text"
                            name="name"
                            required
                        >
                    </div>

                    <div>
                        <label>Destination</label>

                        <input
                            type="text"
                            name="destination"
                            required
                        >
                    </div>

                    <div>
                        <label>Price (৳)</label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="price"
                            required
                        >
                    </div>

                    <div>
                        <label>Availability</label>

                        <input
                            type="number"
                            min="0"
                            name="availability"
                            required
                        >
                    </div>

                    <div>
                        <label>Image</label>

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
                        ></textarea>
                    </div>

                    <div class="full">

                        <button
                            type="submit"
                            class="btn primary"
                        >
                            Add Listing
                        </button>

                        <a
                            href="listings.php"
                            class="btn"
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
    SPValidate.attach(document.getElementById('addListingForm'), {
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
