<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>include Demonstration</title>
</head>
<body>
    <?php
    include "includes/header.php";

    echo "<p>Main page content.</p>";
    echo "<p>This page belongs to $siteName.</p>";

    include "includes/footer.php";
    ?>
</body>
</html>
