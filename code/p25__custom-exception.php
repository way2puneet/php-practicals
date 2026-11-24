<?php
// User-defined exception class for invalid marks
class MarksException extends Exception
{
}

// Throws MarksException when the marks are outside the allowed range
function checkMarks($marks)
{
    if ($marks < 0 || $marks > 100) {
        throw new MarksException("Marks must be between 0 and 100.");
    }
    return "Marks $marks accepted.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User-Defined Exception</title>
</head>
<body>
    <?php
    foreach ([78, 120, -5] as $marks) {
        try {
            echo checkMarks($marks) . "<br>";
        } catch (MarksException $e) {
            echo "MarksException caught: " . $e->getMessage()
                . " (value entered: $marks)<br>";
        }
    }
    ?>
</body>
</html>
