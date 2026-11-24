<?php
$first = 20;
$second = 10;          // must not be zero, because it is used as a divisor

$sum = $first + $second;
$difference = $first - $second;
$product = $first * $second;
$quotient = $first / $second;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arithmetic Operations</title>
</head>
<body>
    <?php
    echo "<h3>Arithmetic Operations on $first and $second</h3>";
    echo "Addition: " . $sum . "<br>";
    echo "Subtraction: " . $difference . "<br>";
    echo "Multiplication: " . $product . "<br>";
    echo "Division: " . $quotient . "<br>";
    ?>
</body>
</html>
