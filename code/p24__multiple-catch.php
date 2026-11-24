<?php
// Checks student details and returns the average marks
function checkStudent($name, $age, $total, $subjects)
{
    if ($age <= 0) {
        throw new InvalidArgumentException("Age must be positive.");
    }
    if (strlen($name) < 3) {
        throw new LengthException("Name must have at least 3 characters.");
    }
    $average = $total / $subjects;  // throws DivisionByZeroError if $subjects is 0
    return "$name: average marks " . round($average, 2);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Multiple Catch Blocks</title>
</head>
<body>
    <?php
    $students = [
        ["Riya", 19, 232, 3],
        ["Aarav", -2, 250, 3],
        ["Al", 20, 180, 2],
        ["Neha", 21, 150, 0],
    ];

    foreach ($students as $s) {
        try {
            echo checkStudent($s[0], $s[1], $s[2], $s[3]) . "<br>";
        } catch (InvalidArgumentException $e) {
            echo "InvalidArgumentException caught: " . $e->getMessage() . "<br>";
        } catch (LengthException $e) {
            echo "LengthException caught: " . $e->getMessage() . "<br>";
        } catch (DivisionByZeroError $e) {
            echo "DivisionByZeroError caught: " . $e->getMessage()
                . " (no subjects entered for " . $s[0] . ")<br>";
        } catch (Exception $e) {
            echo "Other exception caught: " . $e->getMessage() . "<br>";
        }
    }
    ?>
</body>
</html>
