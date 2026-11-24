<?php
$cookieName = "student_name";
$cookieValue = "Anika";
$expires = time() + 7 * 24 * 60 * 60;      // seven days from now

// setcookie() sends a header, so it is called before any output
$created = setcookie($cookieName, $cookieValue, $expires, "/");

date_default_timezone_set("Asia/Kolkata");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create a Cookie</title>
</head>
<body>
    <h2>Cookie Details</h2>
    <?php if ($created): ?>
        <p>Cookie created successfully.</p>
        <p>Name: <?php echo $cookieName; ?></p>
        <p>Value: <?php echo $cookieValue; ?></p>
        <p>Expires on: <?php echo date("d-m-Y H:i:s", $expires); ?></p>
    <?php else: ?>
        <p>The cookie could not be set.</p>
    <?php endif; ?>

    <h3>Reading the Cookie</h3>
    <?php if (isset($_COOKIE[$cookieName])): ?>
        <p>Value received from the browser: <?php echo htmlspecialchars($_COOKIE[$cookieName]); ?></p>
    <?php else: ?>
        <p>The cookie is not yet available in $_COOKIE. Reload the page to read it.</p>
    <?php endif; ?>
</body>
</html>
