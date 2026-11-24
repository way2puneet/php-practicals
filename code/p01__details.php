<?php
// Set the time zone so that date() returns Indian Standard Time
date_default_timezone_set("Asia/Kolkata");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Details</title>
</head>
<body>
    <?php
    echo "<h2>Student Details</h2>";
    echo "Name: Aarav Mehta<br>";
    echo "Course: BCA<br>";
    echo "Date and Time: " . date("d-m-Y H:i:s");
    ?>
</body>
</html>
