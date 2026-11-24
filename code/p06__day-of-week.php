<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Day of the Week</title>
</head>
<body>
    <?php
    $dayNumber = 3;

    switch ($dayNumber) {
        case 1:
            $dayName = "Monday";
            break;
        case 2:
            $dayName = "Tuesday";
            break;
        case 3:
            $dayName = "Wednesday";
            break;
        case 4:
            $dayName = "Thursday";
            break;
        case 5:
            $dayName = "Friday";
            break;
        case 6:
            $dayName = "Saturday";
            break;
        case 7:
            $dayName = "Sunday";
            break;
        default:
            $dayName = "";
    }

    if ($dayName != "") {
        echo "Day $dayNumber is $dayName.";
    } else {
        echo "Invalid day number $dayNumber. Enter a number from 1 to 7.";
    }
    ?>
</body>
</html>
