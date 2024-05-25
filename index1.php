
<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$input_username = isset($_SESSION['user']) ? $_SESSION['user'] : null;

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="quran.png" type="image/x-icon">
<title>Second Page</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

<style>
    body {
        background-color: #f8f9fa; /* Light gray background */
        font-family: Arial, sans-serif;
    }
    .navbar-brand {
        font-size: 24px; /* Increase the font size of the brand/logo */
    }
    .navbar-nav .nav-link {
        font-size: 18px; /* Increase the font size of the buttons */
        padding: 10px 20px; /* Padding for the buttons */
        border-radius: 10px; /* Rounded corners for the buttons */
        background-color: grey; /* Blue background color */
        color: #fff; /* White text color */
    }
    .navbar-nav .nav-link:hover {
        background-color: blue; /* Darker blue background color on hover */
    }
    @media (max-width: 576px) {
        .navbar-brand {
            font-size: 20px; /* Decrease the font size of the brand/logo for smaller screens */
        }
        .navbar-nav .nav-link {
            font-size: 16px; /* Decrease the font size of the buttons for smaller screens */
            width: 100%; /* Make buttons occupy full width on smaller screens */
            margin-bottom: 10px; /* Add space between buttons on smaller screens */
        }
    }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Dashboard 📋</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav text-center w-100">
                <?php if ($input_username == "badr") { ?>
                    <li class="nav-item">
                        <button class="btn btn-lg btn-block" onclick="admin()">Admin</button>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <button class="btn btn-lg btn-block" onclick="update()">Update 🔄</button>
                </li>
                <li class="nav-item">
                    <button class="btn btn-lg btn-block" onclick="disconnect()">Disconnect ✖</button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
   // Close navbar menu when clicking outside of it
   document.addEventListener("DOMContentLoaded", function() {
        let navbarToggler = document.querySelector(".navbar-toggler");
        let navbarCollapse = document.querySelector("#navbarSupportedContent");

        navbarToggler.addEventListener("click", function() {
            if (navbarCollapse.classList.contains("show")) {
                navbarCollapse.classList.remove("show");
            } else {
                navbarCollapse.classList.add("show");
            }
        });

        document.addEventListener("click", function(event) {
            if (!navbarCollapse.contains(event.target) && !navbarToggler.contains(event.target)) {
                navbarCollapse.classList.remove("show");
            }
        });

        // Close navbar menu when clicking on the navbar button
        navbarToggler.addEventListener("click", function() {
            navbarCollapse.classList.toggle("show");
        });
    });
</script>

<script>
    function admin() {
        window.location.href = "ses1.php";
    }

    function update() {
        window.location.href = "update.php";
    }

    function disconnect() {
       
         window.location.href = "logout.php";
        

    }
    function info() {
        window.location.href = "point-info.php";
    }

    // Close the navbar collapse menu when a nav-link is clicked (on mobile)
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            if (navbarToggler && navbarCollapse.classList.contains('show')) {
                navbarToggler.click();
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'view.php'; ?>
