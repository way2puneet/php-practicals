<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Greatest of Three Numbers</title>
</head>
<body>
    <?php
    $a = 25;
    $b = 42;
    $c = 17;

    if ($a >= $b) {
        if ($a >= $c) {
            $greatest = $a;
        } else {
            $greatest = $c;
        }
    } else {
        if ($b >= $c) {
            $greatest = $b;
        } else {
            $greatest = $c;
        }
    }

    echo "Numbers: $a, $b and $c<br>";
    echo "The greatest number is $greatest.";
    ?>
</body>
</html>
