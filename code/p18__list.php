<?php
require "db.php";

$result = mysqli_query($conn,
    "SELECT id, roll_no, name, email, course FROM students ORDER BY id");
$count = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registered Students</title>
    <style>
        table, th, td { border: 1px solid gray; border-collapse: collapse; }
        th, td { padding: 4px 8px; }
    </style>
</head>
<body>
    <h2>Registered Students</h2>
    <p><a href="register.php">Register a new student</a></p>

    <?php if ($count == 0): ?>
        <p>No records found.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th><th>Roll No.</th><th>Name</th>
                <th>E-mail</th><th>Course</th><th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?php echo $row["id"]; ?></td>
                  <td><?php echo htmlspecialchars($row["roll_no"]); ?></td>
                  <td><?php echo htmlspecialchars($row["name"]); ?></td>
                  <td><?php echo htmlspecialchars($row["email"]); ?></td>
                  <td><?php echo htmlspecialchars($row["course"]); ?></td>
                  <td><a href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <p>Total records: <?php echo $count; ?></p>
    <?php endif; ?>
</body>
</html>

<?php
mysqli_free_result($result);
mysqli_close($conn);
?>
