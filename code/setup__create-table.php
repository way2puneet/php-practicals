<?php
require "db.php";

$messages = [];

$createSql = "CREATE TABLE IF NOT EXISTS students (
                  id      INT AUTO_INCREMENT PRIMARY KEY,
                  roll_no VARCHAR(10) NOT NULL UNIQUE,
                  name    VARCHAR(50) NOT NULL,
                  email   VARCHAR(60) NOT NULL,
                  course  VARCHAR(10) NOT NULL
              )";

if (mysqli_query($conn, $createSql)) {
    $messages[] = "Table students is ready.";
} else {
    $messages[] = "Table could not be created: " . mysqli_error($conn);
}

$insertSql = "INSERT INTO students (roll_no, name, email, course) VALUES
              ('2301', 'Aman Verma', 'aman.verma@example.com', 'BCA'),
              ('2302', 'Simran Kaur', 'simran.kaur@example.com', 'BBA'),
              ('2303', 'Rohit Sharma', 'rohit.sharma@example.com', 'BCA')";

if (mysqli_query($conn, $insertSql)) {
    $messages[] = mysqli_affected_rows($conn) . " sample records inserted.";
} elseif (mysqli_errno($conn) == 1062) {
    $messages[] = "Sample records were not inserted again: "
        . mysqli_error($conn);
} else {
    $messages[] = "Sample records could not be inserted: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Table</title>
</head>
<body>
    <?php foreach ($messages as $m): ?>
        <p><?php echo htmlspecialchars($m); ?></p>
    <?php endforeach; ?>
</body>
</html>