<?php
session_start();                      // must come before any output

$_SESSION["student"] = "Anika";       // create session variables
$_SESSION["visits"] = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Store Session Data</title>
</head>
<body>
    <h2>Session Started</h2>
    <p>The name has been stored in the session.</p>
    <p>Session ID: <?php echo session_id(); ?></p>
    <p><a href="session-display.php">Go to the welcome page</a></p>
</body>
</html>
