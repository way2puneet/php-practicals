<?php
// db.php - opens the database connection used by every database page
mysqli_report(MYSQLI_REPORT_OFF);    // functions return false on failure

$conn = mysqli_connect("localhost", "root", "", "college_db");

if ($conn === false) {
    // A simple message for the user; no connection details are shown
    exit("Sorry, the student database is not available at the moment.");
}

mysqli_set_charset($conn, "utf8mb4");
