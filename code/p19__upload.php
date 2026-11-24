<?php
$maxSize = 500 * 1024;                          // 500 KB in bytes
$allowedTypes = ["image/jpeg" => "jpg", "image/png" => "png"];
$message = "";

$roll = trim($_POST["roll"] ?? "");
$file = $_FILES["photo"] ?? null;

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $message = "Please use the upload form.";
} elseif (!ctype_digit($roll) || strlen($roll) != 4) {
    $message = "Upload failed: the roll number must have exactly 4 digits.";
} elseif ($file === null || $file["error"] == UPLOAD_ERR_NO_FILE) {
    $message = "Upload failed: please choose a file to upload.";
} elseif ($file["error"] == UPLOAD_ERR_INI_SIZE || $file["error"] == UPLOAD_ERR_FORM_SIZE) {
    $message = "Upload failed: the file is too large to be uploaded.";
} elseif ($file["error"] != UPLOAD_ERR_OK) {
    $message = "Upload failed: the file could not be received (error code "
        . $file["error"] . ").";
} elseif ($file["size"] == 0 || $file["size"] > $maxSize) {
    $message = "Upload failed: the file must be larger than 0 bytes and not larger than 500 KB.";
} else {
    // Find the real type from the content of the file
    $imageInfo = getimagesize($file["tmp_name"]);
    if ($imageInfo === false || !array_key_exists($imageInfo["mime"], $allowedTypes)) {
        $message = "Upload failed: only JPEG and PNG images are allowed.";
    } else {
        // Safe name made by the program, not taken from the user
        $extension = $allowedTypes[$imageInfo["mime"]];
        $newName = "photo_" . $roll . "." . $extension;
        $target = "uploads/" . $newName;

        if (move_uploaded_file($file["tmp_name"], $target)) {
            $message = "Image uploaded successfully: " . $newName
                . " (" . round($file["size"] / 1024, 1) . " KB, "
                . $imageInfo[0] . " x " . $imageInfo[1] . " pixels).";
        } else {
            $message = "Upload failed: the file could not be saved.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Result</title>
</head>
<body>
    <h2>Upload Result</h2>
    <p><?php echo htmlspecialchars($message); ?></p>
    <p><a href="upload-form.html">Upload another file</a></p>
</body>
</html>
