<?php
session_start();

// Database configuration
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = 'podoxito';
$dbName = 'quran';
$input_username = $_SESSION['user'];

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error || $input_username != "badr") {
    die("Connection failed: " . $conn->connect_error);
}

// Insert new record into the "quran" table
if (isset($_POST['add_quran']) && $input_username == "badr") {
    $name = $_POST["new_quran_name"];
    $pass = $_POST["new_quran_pass"];
    $points = $_POST["new_quran_points"];
    $sura = $_POST["new_quran_sura"];
    $aaya = $_POST["new_quran_aaya"];

    $insert_quran_sql = "INSERT INTO quran (Name, pass, points, sura, aaya) VALUES ('$name', '$pass', '$points', '$sura', '$aaya')";
    $conn->query($insert_quran_sql);
}

// Insert new record into the "code" table
if (isset($_POST['add_code'])) {
    $code = $_POST["new_code_code"];
    $status = 1; // Default status for a new code is 1 (unused)

    $insert_code_sql = "INSERT INTO code (code, status) VALUES ('$code', 1)";
    $conn->query($insert_code_sql);
}

// Delete record from the "quran" table
if (isset($_POST['delete_quran'])) {
    $delete_quran_id = $_POST['delete_quran'];

    $delete_quran_sql = "DELETE FROM quran WHERE id = '$delete_quran_id'";
    $conn->query($delete_quran_sql);
}

// Delete record from the "code" table
if (isset($_POST['delete_code'])) {
    $delete_code_id = $_POST['delete_code'];

    $delete_code_sql = "DELETE FROM code WHERE id = '$delete_code_id'";
    $conn->query($delete_code_sql);
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
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Password</th>
                            <th>Points</th>
                            <th>Sura</th>
                            <th>Aaya</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Existing records from the Quran table -->
                        <?php
                        $quran_sql = "SELECT * FROM quran";
                        $quran_result = $conn->query($quran_sql);
                        while ($row = $quran_result->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><input type="text" name="name<?php echo $row['id']; ?>" value="<?php echo $row['Name']; ?>"></td>
                                <td><input type="text" name="pass<?php echo $row['id']; ?>" value="<?php echo $row['pass']; ?>"></td>
                                <td><input type="text" name="points<?php echo $row['id']; ?>" value="<?php echo $row['points']; ?>"></td>
                                <td><input type="text" name="sura<?php echo $row['id']; ?>" value="<?php echo $row['sura']; ?>"></td>
                                <td><input type="text" name="aaya<?php echo $row['id']; ?>" value="<?php echo $row['aaya']; ?>"></td>
                                <td><button type="submit" class="btn btn-danger btn-sm" name="delete_quran" value="<?php echo $row['id']; ?>">Delete</button></td>
                            </tr>
                        <?php endwhile; ?>

                        <!-- Add new record form for the Quran table -->
                        <tr>
                            <td>New</td>
                            <td><input type="text" name="new_quran_name"></td>
                            <td><input type="text" name="new_quran_pass"></td>
                            <td><input type="text" name="new_quran_points"></td>
                            <td><input type="text" name="new_quran_sura"></td>
                            <td><input type="text" name="new_quran_aaya"></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary" name="add_quran">Add Quran Record</button>

            <h2>Code Table</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Existing records from the Code table -->
                        <?php
                        $code_sql = "SELECT * FROM code";
                        $code_result = $conn->query($code_sql);
                        while ($row = $code_result->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><input type="text" name="code<?php echo $row['id']; ?>" value="<?php echo $row['code']; ?>"></td>
                                <td><input type="text" name="status<?php echo $row['id']; ?>" value="<?php echo $row['status']; ?>"></td>
                                <td><button type="submit" class="btn btn-danger btn-sm" name="delete_code" value="<?php echo $row['id']; ?>">Delete</button></td>
                            </tr>
                        <?php endwhile; ?>

                        <!-- Add new record form for the Code table -->
                        <tr>
                            <td>New</td>
                            <td><input type="text" name="new_code_code"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary" name="add_code">Add Code Record</button>

            <button type="button" class="btn btn-secondary btn-lg" onclick="window.location.href='ses1.php'">Return</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


