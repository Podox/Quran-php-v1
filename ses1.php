<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="quran.png" type="image/x-icon">
<title>PHP Website</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .btn-container {
        text-align: center;
    }
    .btn {
        margin: 10px;
    }
</style>
</head>
<body>

<div class="btn-container">
    <button class="btn btn-primary btn-lg" onclick="window.location.href='addadmin.php'">Add</button>
    <button class="btn btn-secondary btn-lg" onclick="window.location.href='admin.php'">Modify</button>
    <button class="btn btn-secondary btn-lg" onclick="window.location.href='index1.php'">return</button>
    <button class="btn btn-secondary btn-lg" onclick="window.location.href='point.php'">Points</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
