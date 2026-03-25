<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Gematria Calculator (Bulk)</title>
</head>
<body>

<h1>Gematria Calculator (Bulk)</h1>

<p>
    <strong>Instructions! (bulk version)</strong><br>
    The legend is as follows: <strong>a=6, b=12, c=18, d=24, e=30, f=36</strong>, and so on and so forth.<br><br>
    Choose a filter between 6-9996, then select a TXT file to upload (max size 2MB).
    Each word must be on a new line. Each letter of each word will be applied a value
    according to the legend, added together, then filtered according to your selection.
</p>

<form action="beastformbulk.php" method="post" enctype="multipart/form-data">
    <label for="totalfilter">Select filter between 6-9996 (multiples of 6 only)</label>
    <input type="number" name="totalfilter" id="totalfilter" min="6" max="9996" step="6">
    <br><br>
    <label for="fileToUpload">Select TXT file</label>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br><br>
    <input type="submit" value="Upload File" name="submit">
</form>

</body>
</html>
