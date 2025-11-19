<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <!-- <a href="file.php">Download</a> -->
    <span>Download Excel</span>
    <input type="text" id="excel" onkeyup="downloadExcel()" placeholder="Enter a key">
</body>
<script>
    function downloadExcel(){
        let value = document.getElementById('excel').value;
        console.log(value);
        if(value === "1" || value === "2" || value === "3"){
            window.location.href = 'file.php'
        }else{
            alert('You are not allowed to download excel file');
        }
    }
</script>
</html>