<?php
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = 'podoxito';
$dbName = 'quran';
$error_message = NULL;
session_start();
$input_username = $_SESSION['user'];
// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error ||  $input_username!="badr") {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the "quran" table
$quran_sql = "SELECT * FROM quran ORDER BY  Sura DESC, Aaya DESC";
$quran_result = $conn->query($quran_sql);

// Fetch data from the "code" table
$code_sql = "SELECT * FROM code";
$code_result = $conn->query($code_sql);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm"]) && $input_username=="badr") {
    // Process modifications for the Quran table
    while ($row = $quran_result->fetch_assoc()) {
        $id = $row['id'];
        $name = $_POST["name$id"];
        $pass = $_POST["pass$id"];
        $points = $_POST["points$id"];
        $sura = $_POST["sura$id"];
        $aaya = $_POST["aaya$id"];
        
        // Update records in the Quran table
        $update_quran_sql = "UPDATE quran SET Name = '$name', pass = '$pass', points = '$points', sura = '$sura', aaya = '$aaya' WHERE id = '$id'";
        $conn->query($update_quran_sql);
    }

    // Process modifications for the Code table
    while ($row = $code_result->fetch_assoc()) {
        $id = $row['id'];
        $code = $_POST["code$id"];
        $status = $_POST["status$id"];
        
        // Update records in the Code table
        $update_code_sql = "UPDATE code SET code = '$code', status = '$status' WHERE id = '$id'";
        $conn->query($update_code_sql);
    }

    // Refresh the page to reflect changes
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="quran.png" type="image/x-icon">
<title>Quran and Code Tables</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .container {
        margin-top: 50px;
    }
    td input[type="text"] {
        width: 100%;
    }
</style>
</head>
<body>

<div class="container">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h2>Quran Table</h2>
        <?php if ($quran_result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Password</th>
                    <th>Points</th>
                    <th>Sura</th>
                    <th>Aaya</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $quran_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><input type="text" name="name<?php echo $row['id']; ?>" value="<?php echo $row['Name']; ?>"></td>
                    <td><input type="text" name="pass<?php echo $row['id']; ?>" value="<?php echo $row['pass']; ?>"></td>
                    <td><input type="text" name="points<?php echo $row['id']; ?>" value="<?php echo $row['points']; ?>"></td>
                    <td><input type="text" name="sura<?php echo $row['id']; ?>" value="<?php echo $row['sura']; ?>"></td>
                    <td><input type="text" name="aaya<?php echo $row['id']; ?>" value="<?php echo $row['aaya']; ?>"></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No data available in the Quran table.</p>
        <?php endif; ?>
        
        <h2>Code Table</h2>
        <?php if ($code_result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $code_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><input type="text" name="code<?php echo $row['id']; ?>" value="<?php echo $row['code']; ?>"></td>
                    <td><input type="text" name="status<?php echo $row['id']; ?>" value="<?php echo $row['status']; ?>"></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No data available in the Code table.</p>
        <?php endif; ?>
        
        <button type="submit" class="btn btn-primary" name="confirm">Confirm Modifications</button>
        <button type="button" type="submit"class="btn btn-secondary btn-lg" onclick="window.location.href='ses1.php'">return</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>