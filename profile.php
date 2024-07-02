<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "licenta";

    session_start();

    if (!isset($_SESSION["username"])) {
        header("Location: index.php");
        exit();
    }

    // Create a connection
    $conn = new mysqli($server, $username, $password, $dbname);

    $username = $_SESSION["username"];
    $isadmin = $_SESSION["isadmin"];
    $realname = $_SESSION["realname"];

    $querycurrentpassword = "SELECT password FROM User WHERE username = '$username'";
    $resultcurrentpassword = $conn->query($querycurrentpassword);
    $row = $resultcurrentpassword->fetch_assoc();
    $current_password = $row['password'];

    // Fetch user statistics
    $queryStats = "SELECT roundsplayed, totalscore, avgscore, bestscore FROM User WHERE username = '$username'";
    $resultStats = $conn->query($queryStats);
    $rowStats = $resultStats->fetch_assoc();
    $roundsplayed = $rowStats['roundsplayed'];
    $totalscore = $rowStats['totalscore'];
    $avgscore = $rowStats['avgscore'];
    $bestscore = $rowStats['bestscore'];
?>





<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #333;
            color: #fff;
        }

        .header {
            background-color: #111;
            padding: 10px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .menu-button {
            padding: 10px;
            background-color: #111;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 2px solid #555;
        }

        .user-details {
            display: flex;
            align-items: center;
        }

        .user-name {
            color: #fff;
            font-weight: bold;
            margin-right: 10px;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-button {
            background-color: transparent;
            border: none;
            outline: none;
            cursor: pointer;
            width: 10px;
            height: 10px;
            border-top: 2px solid #fff;
            border-right: 2px solid #fff;
            transition: transform 0.3s ease;
        }

        .dropdown-button.arrow-up {
            transform: rotate(45deg);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #111;
            min-width: 120px;
            padding: 10px;
            border-radius: 4px;
            top: 30px;
            right: 0;
        }

        .dropdown-content.show {
            display: block;
        }

        .dropdown-content a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 5px;
            transition: background-color 0.3s ease;
        }

        .dropdown-content a:hover {
            background-color: #333;
        }

        .profile-details {
            margin: 20px;
            background-color: #222;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .profile-details label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .profile-details p {
            margin: 0;
            color: #ccc;
            margin-bottom: 10px;
        }

        .stats-container {
            margin: 20px;
            background-color: #222;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .stats-container label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
            color: #ccc;
        }

        .stats-container p {
            margin: 0;
            color: #ccc;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var dropdownButton = document.querySelector(".dropdown-button");
            var dropdownContent = document.querySelector(".dropdown-content");

            dropdownButton.addEventListener("click", function() {
                dropdownContent.classList.toggle("show");
                dropdownButton.classList.toggle("arrow-up");
            });

            document.addEventListener("click", function(event) {
                if (!dropdownContent.contains(event.target) && !dropdownButton.contains(event.target)) {
                    dropdownContent.classList.remove("show");
                    dropdownButton.classList.remove("arrow-up");
                }
            });
        });

        function goToMainPage() {
            window.location.href = "main_page.php";
        }
    </script>
</head>
<body>
    

    <div class="header">
        <div class="user-info">
            <div class="menu-button" onclick="goToMainPage()">Menu</div>
            <div class="user-details">
                <div class="user-name"><?php echo $realname; ?></div>
                <div class="dropdown">
                    <button class="dropdown-button"></button>
                    <div class="dropdown-content">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-details">
        <label>Username:</label>
        <p><?php echo $username; ?></p><br></br>
        <label>Password:</label>
        <p><?php echo $current_password; ?></p><br></br>
        <label>Real Name:</label>
        <p><?php echo $realname; ?></p>
    </div>

    <div class="stats-container">
        <label>User Statistics:</label>
        <p>Number of Rounds Played: <?php echo $roundsplayed; ?></p>
        <p>Total Score: <?php echo $totalscore; ?></p>
        <p>Average Score: <?php echo $avgscore; ?></p>
        <p>Best Score: <?php echo $bestscore; ?></p>
    </div>
</body>
</html>
