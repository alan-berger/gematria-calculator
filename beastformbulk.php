<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Gematria Calculator (Bulk)</title>
</head>
<body>

<h1>Gematria Calculator (Bulk)</h1>

<?php

const MAX_FILE_BYTES = 2 * 1024 * 1024; // 2MB server-side cap

// Calculate Gematria value for a single word (a=6, b=12, ... z=156).
function gematria_value(string $word): int {
    $total = 0;
    $lower = strtolower($word);
    for ($i = 0, $len = strlen($lower); $i < $len; $i++) {
        $ord = ord($lower[$i]);
        if ($ord >= 97 && $ord <= 122) {
            $total += ($ord - 96) * 6;
        }
    }
    return $total;
}

// Validate the filter value server-side: must be an integer, multiple of 6, between 6 and 9996.
$filter = isset($_POST['totalfilter']) ? intval($_POST['totalfilter']) : 0;
if ($filter < 6 || $filter > 9996 || $filter % 6 !== 0) {
    echo '<p>Invalid filter value. Please go back and enter a multiple of 6 between 6 and 9996.</p>';
} else {
    // Check the PHP-level upload error code before touching the file.
    $upload_error = $_FILES['fileToUpload']['error'] ?? -1;
    if ($upload_error !== UPLOAD_ERR_OK) {
        $msg = match($upload_error) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'File exceeds the maximum allowed size.',
            UPLOAD_ERR_NO_FILE                        => 'No file was selected.',
            default                                   => 'Upload failed (error code ' . $upload_error . ').',
        };
        echo '<p>' . htmlentities($msg, ENT_QUOTES, 'UTF-8') . '</p>';
    } else {
        $tmp = $_FILES['fileToUpload']['tmp_name'];

        // Confirm the file arrived via a legitimate HTTP upload.
        if (!is_uploaded_file($tmp)) {
            echo '<p>Invalid file upload.</p>';
        } elseif ($_FILES['fileToUpload']['size'] > MAX_FILE_BYTES) {
            // Enforce the 2MB limit server-side regardless of what the form says.
            echo '<p>File exceeds the 2MB maximum size.</p>';
        } elseif (strtolower(pathinfo(basename($_FILES['fileToUpload']['name']), PATHINFO_EXTENSION)) !== 'txt') {
            echo '<p>Only .txt files are allowed.</p>';
        } else {
            $content = file_get_contents($tmp);

            // file_get_contents returns false on failure; an empty file returns "".
            // Treat both as unreadable rather than silently showing zero results.
            if ($content === false) {
                echo '<p>Sorry, there was an error reading your file.</p>';
            } elseif ($content === '') {
                echo '<p>The uploaded file is empty.</p>';
            } else {
                // Split on any whitespace, drop empty strings, deduplicate.
                $words = array_unique(array_filter(preg_split('/\s+/', $content)));

                $count = 0;
                foreach ($words as $word) {
                    $total = gematria_value($word);
                    if ($total === $filter) {
                        $count++;
                        $safe_word = htmlentities($word, ENT_QUOTES, 'UTF-8');
                        echo "<pre>{$safe_word} = {$total}</pre>\n";
                    }
                }

                echo '<p>' . $count . ' match' . ($count !== 1 ? 'es' : '') . ' found.</p>';
            }
        }
    }
}
?>

<a href="beastcalcbulk.php">Try again</a>

</body>
</html>
