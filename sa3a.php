<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="quran.png" type="image/x-icon">
<title>Live Date and Time</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<style>
    .container {
        margin-top: 50px;
    }
</style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Live Date and Time</h2>
    
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">Current Date:</h3>
                    <p class="card-text" id="current-date"></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">Current Time:</h3>
                    <p class="card-text" id="current-time"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function updateTime() {
        var currentDateElement = document.getElementById('current-date');
        var currentTimeElement = document.getElementById('current-time');

        var currentDate = new Date();
        var hours = currentDate.getHours();
        var minutes = currentDate.getMinutes();
        var seconds = currentDate.getSeconds();
        
        // Add leading zeros if needed
        hours = (hours < 10 ? "0" : "") + hours;
        minutes = (minutes < 10 ? "0" : "") + minutes;
        seconds = (seconds < 10 ? "0" : "") + seconds;

        currentDateElement.textContent = currentDate.toISOString().slice(0, 10);
        currentTimeElement.textContent = hours + ":" + minutes + ":" + seconds;
    }

    // Update time immediately and then every second
    updateTime();
    setInterval(updateTime, 1000);
</script>
</body>
</html>
