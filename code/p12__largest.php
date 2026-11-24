<?php
// Returns the largest value in an array, or null if the array is empty
function findLargest($numbers)
{
    if (count($numbers) == 0) {
        return null;
    }

    $largest = $numbers[0];          // initial largest value
    foreach ($numbers as $value) {
        if ($value > $largest) {
            $largest = $value;       // a greater value has been found
        }
    }
    return $largest;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Largest Value in an Array</title>
</head>
<body>
    <?php
    $marks = [45, 78, 91, 62, 88];
    echo "Marks: " . implode(", ", $marks) . "<br>";
    echo "Largest value: " . findLargest($marks) . "<br>";

    $empty = [];
    $result = findLargest($empty);
    if ($result === null) {
        echo "The second array has no elements.";
    }
    ?>
</body>
</html>
