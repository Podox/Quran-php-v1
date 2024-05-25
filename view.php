<?php
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = 'podoxito';
$dbName = 'quran';
$error_message = NULL;

if(isset($_SESSION['user'])) {
    $input_username = $_SESSION['user'];
} else {
    // Handle the case where input_username is not set in the session
    // For example, redirect the user to the login page    
echo "error";
header("location: logout.php");
header('Location: index.php');
    exit();
}
$current_date = date('Y-m-d');
// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Complete the SQL query to count the number of records with today's date
$SQL_COUNT = "SELECT COUNT(DISTINCT id) FROM updata WHERE DATE(date) = '$current_date'";

// Execute the query
$count_result = $conn->query($SQL_COUNT);

// Check if the query was successful
if ($count_result === FALSE) {
    // Handle the case where the query failed
    $error_message .= " Error counting records: " . $conn->error;
} else {
    // Fetch the count value from the query result
    $count_row = $count_result->fetch_assoc();
    $record_count = $count_row['COUNT(DISTINCT id)'];

    // Use the $record_count as needed
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="quran.png" type="image/x-icon">
<title>Quran Data</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .container {
        margin-top: 50px;
    }
    .welcome-message {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }
    .highlight {
        background-color: #B3EC41; /* Highlight color */
        font-weight: bold; /* Bold text */
    }
    .wave {
    font-size: 24px;
    display: inline-block;
}

.wave:before {
    content: "👋";
    display: inline-block;
    animation: wave 2s infinite;
}

@keyframes wave {
    0%, 100% { transform: rotate(8deg); }
    25% { transform: rotate(9deg); } /* Adjust the degree for smoother animation */
    50% { transform: rotate(10deg); }
    75% { transform: rotate(-10deg); } 
}

/* Custom styles for buttons */
.button-group {
    display: flex;
    justify-content: center;
    gap: 10px;
}

/* Active button style */
.active {
    background-color: #6c757d; /* Grey color */
    color: #fff;
    border-color: #6c757d;
}

</style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="welcome-message">
            <div class="wave"></div>
                <?php echo " Welcome, $input_username "; ?><br>
                <?php  if ($record_count > 1) {
    echo " $record_count People Read the Quran Today!";
} else {
    echo " $record_count Person Read the Quran Today!";
} ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
         
        </div>
    </div>
    <div class="row mt-3"> 
    <div class="row">
        <div class="col">
            <?php
            

            $sql = "SELECT ROW_NUMBER() OVER (ORDER BY q.points DESC, q.Sura DESC, q.Aaya DESC) AS Position,
            q.Name AS Name, 
            CONCAT(sn.sura_number, '-', sn.sura_name) AS Sura, 
            q.Aaya AS Aaya, 
            q.points AS Khatm 
        FROM quran q
        JOIN sura_names sn ON q.Sura = sn.sura_number";


$result = $conn->query($sql);

// Display the data in a Bootstrap table
if ($result->num_rows > 0) {
    echo "<table id='quranTable' class='table table-striped table-bordered'>";
    
    // Table header
    $header = true;
    while($row = $result->fetch_assoc()) {
        if ($header) {
            echo "<thead class='thead-dark'><tr>";
            foreach($row as $key => $value) {
                echo "<th>" . ucfirst($key) . "</th>";
            }
            echo "</tr></thead>";
            echo "<tbody>";
            $header = false;
        }
        
        // Table rows
        // Check if the "Name" column matches the input username, then apply the highlight to the entire row
        $highlightClass = ($row["Name"] === $input_username) ? "highlight" : "";
        echo "<tr class='$highlightClass'>";
        foreach($row as $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    
    echo "</tbody></table>";
} else {
    echo "0 results";
}
            // Close the connection
            $conn->close();
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function sortBy(sortType) {
        var pointsButton = document.getElementById('sortByPoints');
        var suraButton = document.getElementById('sortBySura');
        
        // Toggle active class
        if (sortType === 'points') {
            pointsButton.classList.add('active');
            suraButton.classList.remove('active');
        } else {
            suraButton.classList.add('active');
            pointsButton.classList.remove('active');
        }

        // Reload the page with the updated sort order
        window.location.href = window.location.pathname + '?sort=' + sortType;
    }
</script>
</body>
</html>
