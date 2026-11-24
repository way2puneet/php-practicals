<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Three Types of Arrays</title>
</head>
<body>
    <?php
    // 1. Indexed array created with the array() construct
    $subjects = array("PHP", "MySQL", "HTML");
    echo "<h3>Indexed Array</h3>";
    echo "Indexed: " . implode(", ", $subjects) . "<br>";
    echo "Second subject (index 1): " . $subjects[1] . "<br>";

    // 2. Associative array created with the bracket form
    $student = ["name" => "Riya", "course" => "BCA", "semester" => 6];
    echo "<h3>Associative Array</h3>";
    echo "Name: " . $student["name"] . "<br>";
    echo "Course: " . $student["course"] . "<br>";
    echo "Semester: " . $student["semester"] . "<br>";

    // 3. Multidimensional array: each row is an associative array
    $results = [
        ["name" => "Riya", "PHP" => 78, "MySQL" => 85],
        ["name" => "Aarav", "PHP" => 91, "MySQL" => 74],
    ];
    echo "<h3>Multidimensional Array</h3>";
    echo "PHP Marks: " . $results[0]["PHP"] . "<br>";
    foreach ($results as $row) {
        echo $row["name"] . " - PHP: " . $row["PHP"]
            . ", MySQL: " . $row["MySQL"] . "<br>";
    }
    ?>
</body>
</html>
