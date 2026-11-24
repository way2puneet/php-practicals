<?php
mysqli_report(MYSQLI_REPORT_OFF);

$conn = mysqli_connect("localhost", "root", "");    // no database selected
if ($conn === false) {
    exit("Could not connect to the MySQL server.");
}

$sql = "CREATE DATABASE IF NOT EXISTS college_db
        CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";

if (mysqli_query($conn, $sql)) {
    $message = "Database college_db is ready.";
} else {
    $message = "Database could not be created: " . mysqli_error($conn);
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Database</title>
</head>
<body>
    <p><?php echo htmlspecialchars($message); ?></p>
</body>
</html>