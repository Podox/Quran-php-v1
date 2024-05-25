<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $password = $_POST["password"];
    $code = $_POST["code"]; // Retrieve the code entered by the user

    // Check if the entered code exists in the table and has status 1 (indicating it can be used)
    $sql = "SELECT * FROM code WHERE code = '$code' AND status = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Code exists and can be used, proceed with creating the account

        // Check if a similar name exists in the database
        $check_sql = "SELECT * FROM quran WHERE Name = '$name'";
        $check_result = $conn->query($check_sql);
        if ($check_result->num_rows > 0) {
            // A similar name exists, display error message
            $error_message = "Error: A similar name already exists. Please choose a different name.";
        } else {
            // Fetch the row from the query result
            $row = $result->fetch_assoc();
            $code_id = $row["id"];

            // Prepare and execute SQL statement to update the code's status to 0 (used)
            $update_sql = "UPDATE code SET status = 0 WHERE id = $code_id";
            if ($conn->query($update_sql) === TRUE) {
                // Prepare and execute SQL statement to insert account data into the database
                $insert_sql = "INSERT INTO quran (Name, pass,points,sura,aaya) VALUES ('$name', '$password','0','0','0')";
                if ($conn->query($insert_sql) === TRUE) {
                    $success_message = "Account created successfully";
                } else {
                    $error_message = "Error creating account: " . $conn->error;
                }
            } else {
                $error_message = "Error updating code status: " . $conn->error;
            }
        }
    } else {
        // Code does not exist or is already used, display error message
        $error_message = "Error: Incorrect or used verification code";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="quran.png" type="image/x-icon">
<title>Create Account</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<style>
    .container {
        margin-top: 50px;
    }
    .btn-return {
        background-color: #ff6b6b;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-weight: bold;
        transition: background-color 0.3s, transform 0.3s;
    }
</style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Create an Account</h2>
    
    <!-- PHP success/error messages here -->
    <!-- Success message -->
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <!-- Error message -->
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Verification Code:</label>
            <input type="text" class="form-control" id="code" name="code" placeholder="Enter verification code" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Account</button>
    </form>

    <button class="btn btn-return mt-3" onclick="goBack()">Return</button>
</div>

<script>
    function goBack() {
        window.location.href = "index.php";
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
