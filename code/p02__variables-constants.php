<?php
const MAX_MARKS = 100;                   // constant created with const
define("COURSE_CODE", "BCA-PHP");        // constant created with define()

$studentName = "Neha Gupta";             // variable holding text
$semester = 5;                           // variable holding a number
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Variables and Constants</title>
</head>
<body>
    <?php
    echo "<h3>Variables</h3>";
    echo "Student: $studentName<br>";
    echo "Semester (first value): $semester<br>";

    $semester = 6;                       // a variable can be given a new value
    echo "Semester (changed value): $semester<br>";

    echo "<h3>Constants</h3>";
    echo "Course Code: " . COURSE_CODE . "<br>";
    echo "Maximum Marks: " . MAX_MARKS;
    ?>
</body>
</html>
