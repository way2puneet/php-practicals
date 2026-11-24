<?php
require "includes/config.php";    // the page cannot work without these settings
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>require Demonstration</title>
</head>
<body>
    <?php
    echo "<p>Required file loaded.</p>";
    echo "<p>Page processing continues for $collegeName.</p>";
    echo "<p>Course: $course, Academic Year: " . ACADEMIC_YEAR . "</p>";
    ?>
</body>
</html>
