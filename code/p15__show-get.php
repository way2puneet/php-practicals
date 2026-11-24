<?php
// Read the values sent in the URL; use "" if a value is missing
$name = $_GET["name"] ?? "";
$course = $_GET["course"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submitted Data (GET)</title>
</head>
<body>
    <h2>Submitted Data</h2>
    <?php if ($name != ""): ?>
        <p>Name: <?php echo htmlspecialchars($name); ?></p>
        <p>Course: <?php echo htmlspecialchars($course); ?></p>
        <p>Method used: GET</p>
    <?php else: ?>
        <p>No data was received. Please fill the form first.</p>
    <?php endif; ?>
    <p><a href="get-form.html">Back to the form</a></p>
</body>
</html>
