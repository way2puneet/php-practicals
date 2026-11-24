<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>String Cleanup Functions</title>
</head>
<body>
    <pre>
<?php
$text = "  PHP Programming  ";       // two spaces at each end

echo "Original:    [" . $text . "]  length " . strlen($text) . "\n";
echo "After trim:  [" . trim($text) . "]  length " . strlen(trim($text)) . "\n";
echo "After ltrim: [" . ltrim($text) . "]  length " . strlen(ltrim($text)) . "\n";
echo "After rtrim: [" . rtrim($text) . "]  length " . strlen(rtrim($text)) . "\n";

$code = "--BCA--";
echo "Hyphens removed: [" . trim($code, "-") . "]\n";
?>
    </pre>
</body>
</html>
