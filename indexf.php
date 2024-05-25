<?php
session_start();

// Database configuration
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = 'podoxito';
$dbName = 'quran';
$error_message = NULL;

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];
   
    // Prepare SQL statement
    $sql = "SELECT * FROM quran WHERE BINARY Name = '$input_username'";
 
    // Execute SQL statement
    $result = $conn->query($sql);
    
    if ($result === false) {
        // Display SQL error
        die("Error: " . $conn->error);
    }
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row["pass"] == $input_password) {
            // Password is correct, redirect to second page
            $_SESSION['user'] = $input_username;
            // Insert data into the con-logs table
    $current_date = date('Y-m-d H:i:s'); // Get current date and time
    $sql_insert = "INSERT INTO conlogs (Name, date) VALUES ('$input_username', '$current_date')";
    $conn->query($sql_insert);
            header("Location: index1.php");
            exit();
        } else {
            // Incorrect password, set error message
            $error_message = "Incorrect password";
        }
    } else {
        // User does not exist, set error message
        $error_message = "User does not exist";
    }
} 

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="quran.png" type="image/x-icon">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .container {
        margin-top: 50px; /* Added margin to center the form vertically */
    }
</style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Ramadan Quran Marathon🏃‍♂️🕋</h2>
    <h2 class="text-center">☪︎Login☪︎</h2>
     <!-- Notification -->
     <div class="alert alert-info" role="alert">
     Points are replaced with the number of times you've completed reading the Quran.</div>
    <!-- End of Notification -->
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary mb-3 w-100">Login</button> <!-- Added w-100 class for full width on all devices -->
                <?php if(isset($error_message)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php } ?>
            </form>
        </div>
        <div class="col-12 text-center"> <!-- Removed col-md-6 class to center the button on all screen sizes -->
            <a href="create_account.php" class="btn btn-secondary">Create Account</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>