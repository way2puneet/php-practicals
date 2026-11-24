<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>String Case Functions</title>
</head>
<body>
    <?php
    $text = "PHP Programming";
    echo "Original: $text<br><br>";

    echo "strtolower(): " . strtolower($text) . "<br>";
    echo "strtoupper(): " . strtoupper($text) . "<br>";
    echo "ucfirst(): " . ucfirst($text) . "<br>";
    echo "ucwords(): " . ucwords($text) . "<br><br>";

    echo "ucfirst(strtolower()): " . ucfirst(strtolower($text)) . "<br>";
    echo "ucwords(strtolower()): " . ucwords(strtolower($text)) . "<br><br>";

    $entered = "bca";
    $courseCode = "BCA";
    if (strtoupper($entered) == $courseCode) {
        echo "The entered course \"$entered\" matches $courseCode.";
    }
    ?>
</body>
</html>
