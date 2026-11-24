<?php
$submitted = ($_SERVER["REQUEST_METHOD"] == "POST");

// Read the values sent in the request body
$name = $_POST["name"] ?? "";
$course = $_POST["course"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submitted Data (POST)</title>
</head>
<body>
    <h2>Submitted Data</h2>
    <?php if ($submitted): ?>
        <p>Name: <?php echo htmlspecialchars($name); ?></p>
        <p>Course: <?php echo htmlspecialchars($course); ?></p>
        <p>Method used: <?php echo $_SERVER["REQUEST_METHOD"]; ?></p>
    <?php else: ?>
        <p>This page must be opened by submitting the form.</p>
    <?php endif; ?>
    <p><a href="post-form.html">Back to the form</a></p>
</body>
</html>
