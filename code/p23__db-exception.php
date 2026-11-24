<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);   // throw exceptions

$database = "college_db";
$conn = null;
$message = "";
try 
{
$conn = mysqli_connect("localhost", "root", "", $database);
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students");
$row = mysqli_fetch_assoc($result);
$message = "Database connection established. Students registered: " . $row["total"];
} 
catch (mysqli_sql_exception $e) 
{
    // Technical details for the developer only
    error_log("Database error " . $e->getCode() . ": " . $e->getMessage());
 // Simple message for the user
$message = "Database connection could not be established. Please try again later.";
} 
finally 
{
    if ($conn) 
    {
        mysqli_close($conn);           // cleanup when the connection was opened
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Connection Exception</title>
</head>
<body>
    <h2>Student Database</h2>
    <p><?php echo htmlspecialchars($message); ?></p>
</body>
</html>
