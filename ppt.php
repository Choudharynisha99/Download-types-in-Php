<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download PPT</title>
</head>
<body>
    <!-- <img src="code-review-tools.png" alt="" width="200" height="200">
    <img src="code-review-tools.png" alt="" width="200" height="200">
    <img src="code-review-tools.png" alt="" width="200" height="200">
    <img src="code-review-tools.png" alt="" width="200" height="200">
   <button>
    <a href="download-ppt.php" style="text-decoration:none">Download PPT</a>
</button> -->
<form action="ppt-download.php" method="post" enctype="multipart/form-data">
    <input type="file" name="images[]" multiple >
    <br>
    <button type="submit">Download PPT</button>
</form>
</body>
</html>