<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Consecutive Streaks</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Add custom styles here */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 50px;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
    }

    th, td {
        
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #343a40;
        color: #fff;
    }

    tbody tr:hover {
        background-color: #f2f2f2;
    }

</style>
</head>
<body>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="quran.png" type="image/x-icon">
<title>Consecutive Streaks</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 50px;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        color: #000; /* Change text color to black */
    }

    th {
        background-color: #343a40;
        color: black;
    }

    tbody tr:hover {
        background-color: #f2f2f2;
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 24px; /* Adjust font size for smaller screens */
        }
    }
</style>
</head>
<body>

<div class="container">
    <h1 class="mt-5 mb-3">Consecutive Streaks</h1>
    <div class="row">
        <div class="col">
            <!-- Your PHP code here -->
            <button class="btn btn-secondary btn-lg" onclick="window.location.href='ses1.php'">Return</button>
            <?php
            $host = 'localhost';
            $dbUsername = 'root';
            $dbPassword = 'podoxito';
            $dbName = 'quran';
            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
            session_start();
            $input_username = $_SESSION['user'];
            if ($conn->connect_error || $input_username != "badr" ) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to fetch consecutive streaks
            $sql = "SELECT Name,
                           MIN(StreakStartDate) AS StreakStartDate,
                           MAX(StreakEndDate) AS StreakEndDate,
                           COUNT(*) AS ConsecutiveDates,
                           SUM(ConsecutiveDates) AS TotalConsecutiveDays
                    FROM (
                        SELECT Name,
                               MIN(Date) AS StreakStartDate,
                               MAX(Date) AS StreakEndDate,
                               COUNT(*) AS ConsecutiveDates
                        FROM (
                            SELECT Name,
                                   Date,
                                   ROW_NUMBER() OVER (PARTITION BY Name ORDER BY Date) - 
                                   ROW_NUMBER() OVER (PARTITION BY Name, DATE(Date) ORDER BY Date) AS streak_group
                            FROM updata
                        ) AS t1
                        GROUP BY Name, streak_group
                    ) AS t2
                    GROUP BY Name
                    ORDER BY StreakStartDate";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr><th>Name</th><th>Start Date</th><th>End Date</th><th>Consecutive Dates</th><th>Total Consecutive Days</th></tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["Name"]."</td>";
                    echo "<td>".$row["StreakStartDate"]."</td>";
                    echo "<td>".$row["StreakEndDate"]."</td>";
                    echo "<td>".$row["ConsecutiveDates"]."</td>";
                    echo "<td>".$row["TotalConsecutiveDays"]."</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
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
</body>
</html>
