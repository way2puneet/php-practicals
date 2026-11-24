<?php
mysqli_report(MYSQLI_REPORT_OFF);    // functions return false on failure

$host = "localhost";
$username = "root";
$password = "";                      // XAMPP default: no password for root
$database = "college_db";

$conn = mysqli_connect($host, $username, $password, $database);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MySQL Connection</title>
</head>
<body>
    <h2>Testing the Database Connection</h2>
    <?php
    if ($conn === false) {
        echo "<p>Database connection failed.</p>";
        echo "<p>Error number: " . mysqli_connect_errno() . "</p>";
        echo "<p>Reason: " . htmlspecialchars(mysqli_connect_error()) . "</p>";
    } else {
        echo "<p>Database connection successful.</p>";
        echo "<p>Connected to database: $database</p>";
        echo "<p>Server version: " . mysqli_get_server_info($conn) . "</p>";
        mysqli_close($conn);
        echo "<p>The connection has been closed.</p>";
    }
    ?>
</body>
</html>
