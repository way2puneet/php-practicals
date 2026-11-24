<?php
require "db.php";

$courses = ["BCA", "BBA", "B.Com"];
$roll = $name = $email = $course = "";
$errors = [];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Read and validate the submitted values
    $roll = trim($_POST["roll"] ?? "");
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $course = $_POST["course"] ?? "";

    if (!ctype_digit($roll) || strlen($roll) != 4) {
        $errors["roll"] = "Roll number must have exactly 4 digits.";
    }
    if (strlen($name) < 3) {
        $errors["name"] = "Name must have at least 3 characters.";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors["email"] = "Enter a valid e-mail address.";
    }
    if (!in_array($course, $courses)) {
        $errors["course"] = "Select a course from the list.";
    }

    if (count($errors) == 0) {
        // Prepared INSERT statement with four placeholders
        $sql = "INSERT INTO students (roll_no, name, email, course)
                VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $roll, $name, $email, $course);

        if (mysqli_stmt_execute($stmt)) {
            $message = "Registration completed successfully. Student ID: "
                . mysqli_insert_id($conn) . ".";
            $roll = $name = $email = $course = "";      // clear the form
        } elseif (mysqli_stmt_errno($stmt) == 1062) {
            $errors["roll"] = "This roll number is already registered.";
        } else {
            error_log("Registration failed: " . mysqli_stmt_error($stmt));
            $message = "Sorry, the registration could not be saved. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
    <style>.error { color: red; }</style>
</head>
<body>
    <h2>Student Registration</h2>
    <p><a href="list.php">View registered students</a></p>

    <?php if ($message != ""): ?>
        <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
    <?php endif; ?>

    <form method="post">
        <p>
            <label for="roll">Roll Number:</label>
            <input type="text" id="roll" name="roll"
                   value="<?php echo htmlspecialchars($roll); ?>">
            <span class="error"><?php echo $errors["roll"] ?? ""; ?></span>
        </p>
        <p>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name"
                   value="<?php echo htmlspecialchars($name); ?>">
            <span class="error"><?php echo $errors["name"] ?? ""; ?></span>
        </p>
        <p>
            <label for="email">E-mail:</label>
            <input type="text" id="email" name="email"
                   value="<?php echo htmlspecialchars($email); ?>">
            <span class="error"><?php echo $errors["email"] ?? ""; ?></span>
        </p>
        <p>
            <label for="course">Course:</label>
            <select id="course" name="course">
                <option value="">-- Select --</option>
                <?php foreach ($courses as $c): ?>
                    <option value="<?php echo $c; ?>"
                     <?php if ($course == $c) echo "selected"; ?>><?php echo $c; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="error"><?php echo $errors["course"] ?? ""; ?></span>
        </p>
        <input type="submit" value="Register">
    </form>
</body>
</html>
