<?php
$allowed = ["Light", "Dark"];
$message = "";

// Preference saved on an earlier visit, if any
$saved = $_COOKIE["theme"] ?? "";
if (!in_array($saved, $allowed)) {
    $saved = "";                         // ignore a missing or changed value
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $theme = $_POST["theme"] ?? "";
    if (in_array($theme, $allowed)) {
        setcookie("theme", $theme, time() + 30 * 24 * 60 * 60, "/");
        $saved = $theme;                 // use the new value on this request
        $message = "Preference saved: $theme";
    } else {
        $message = "Please choose a valid theme.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Theme Preference</title>
</head>
<body>
    <h2>Theme Preference</h2>

    <?php if ($message != ""): ?>
        <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
    <?php elseif ($saved != ""): ?>
        <p>Your saved theme preference: <?php echo $saved; ?></p>
    <?php else: ?>
        <p>No preference has been saved yet.</p>
    <?php endif; ?>

    <form method="post">
        <label for="theme">Choose a theme:</label>
        <select id="theme" name="theme">
            <?php foreach ($allowed as $t): ?>
                <option value="<?php echo $t; ?>"
                    <?php if ($t == $saved) echo "selected"; ?>><?php echo $t; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Save Preference">
    </form>
</body>
</html>
