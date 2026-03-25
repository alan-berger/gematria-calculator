<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Gematria Calculator</title>
</head>
<body>

<h1>Gematria Calculator</h1>

<?php
// Safely read POST input: default to empty string if not set,
// trim whitespace, and enforce the 128-character server-side limit.
$raw_input = substr(trim($_POST['beastinput'] ?? ''), 0, 128);

// Calculate the Gematria total (a=6, b=12, ... z=156).
// ord('a') = 97, so (ord - 96) * 6 gives the correct value.
// strtolower handles both cases in one pass.
$total = 0;
$lower_input = strtolower($raw_input);
for ($i = 0, $len = strlen($lower_input); $i < $len; $i++) {
    $ord = ord($lower_input[$i]);
    if ($ord >= 97 && $ord <= 122) {
        $total += ($ord - 96) * 6;
    }
}

// Escape output for safe HTML display.
$safe_input = htmlentities($raw_input, ENT_QUOTES, 'UTF-8');
echo '<p>' . $safe_input . ' = ' . $total . '</p>';
?>

<a href="beastcalc.php">Try again</a>

</body>
</html>
