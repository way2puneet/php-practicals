<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Array Iteration and Pointer Functions</title>
</head>
<body>
    <?php
    $colours = ["Red", "Green", "Blue"];

    // Iteration with foreach (PHP 8 replacement for each())
    echo "<h3>Iteration with foreach</h3>";
    foreach ($colours as $colour) {
        echo $colour . " ";
    }
    echo "<br>";
    foreach ($colours as $index => $colour) {
        echo "Index $index: $colour<br>";
    }

    // Pointer functions
    echo "<h3>Pointer Functions</h3>";
    echo "Current: " . current($colours) . "<br>";
    echo "Next: " . next($colours) . "<br>";
    echo "Previous: " . prev($colours) . "<br>";
    echo "End: " . end($colours) . "<br>";
    echo "Reset: " . reset($colours) . "<br>";
    ?>
</body>
</html>
