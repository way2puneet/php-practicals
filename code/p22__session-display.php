<?php
session_start();                      // resume the existing session

if (isset($_SESSION["student"])) {
    $_SESSION["visits"]++;            // modify a session variable
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body>
    <?php if (isset($_SESSION["student"])): ?>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION["student"]); ?>.</h2>
        <p>Visits to this page in the current session: <?php echo $_SESSION["visits"]; ?></p>
        <p><a href="session-display.php">Reload this page</a></p>
    <?php else: ?>
        <h2>Welcome, Guest.</h2>
        <p>No session data was found. <a href="session-store.php">Start a session</a>.</p>
    <?php endif; ?>
</body>
</html>
