
<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Travel Tip - Smart Travel Planner</title>

    <link rel="stylesheet"
          href="../../style.css">

</head>

<body>

<div class="travel-tips-container">

    <h1>Edit Travel Tip</h1>

    <p>Update your travel advice.</p>

    <?php if (isset($error)) { ?>

        <div class="tip-error">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php } ?>

    <form method="POST"
          action="/web-technology/smart-travel-planner/travel_tip_mvc.php?action=update">

        <input type="hidden"
               name="tip_id"
               value="<?php echo $tip["tip_id"]; ?>">

        <label for="title">
            Tip Title
        </label>

        <input type="text"
               id="title"
               name="title"
               value="<?php echo htmlspecialchars($tip["title"]); ?>"
               required>

        <label for="description">
            Travel Tip
        </label>

        <textarea id="description"
                  name="description"
                  required><?php echo htmlspecialchars($tip["description"]); ?></textarea>

        <button type="submit">
            Update Travel Tip
        </button>

    </form>

    <a href="/web-technology/smart-travel-planner/travel_tip_mvc.php?action=manage"
       class="back-btn">
        ← Back to My Travel Tips
    </a>

</div>

</body>

</html>

