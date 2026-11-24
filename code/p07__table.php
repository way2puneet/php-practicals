<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Multiplication Table</title>
</head>
<body>
    <?php
    $number = 5;
    echo "<h3>Multiplication Table of $number</h3>";

    for ($i = 1; $i <= 10; $i++) {
        $product = $number * $i;
        echo "$number &times; $i = $product<br>";
    }
    ?>
</body>
</html>
