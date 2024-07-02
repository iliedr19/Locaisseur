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

?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
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

        .leaderboard-table {
            width: 80%;
            margin: 20px auto;
            background-color: #222;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .leaderboard-table th,
        .leaderboard-table td {
            border: 1px solid #555;
            padding: 8px;
            text-align: left;
        }

        .leaderboard-table th {
            background-color: #111;
            color: #fff;
            font-weight: bold;
        }

        .leaderboard-table tr:nth-child(even) {
            background-color: #333;
        }

        .leaderboard-table tr:nth-child(odd) {
            background-color: #444;
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

<table class="leaderboard-table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Real Name</th>
            <th>Rounds Played</th>
            <th>Total Score</th>
            <th>Average Score</th>
            <th>Best Score</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch leaderboard data
        $queryLeaderboard = "SELECT username, realname, roundsplayed, totalscore, avgscore, bestscore FROM User ORDER BY totalscore DESC";
        $resultLeaderboard = $conn->query($queryLeaderboard);

        if ($resultLeaderboard->num_rows > 0) {
            // Output data of each row
            while($row = $resultLeaderboard->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["realname"] . "</td>";
                echo "<td>" . $row["roundsplayed"] . "</td>";
                echo "<td>" . $row["totalscore"] . "</td>";
                echo "<td>" . $row["avgscore"] . "</td>";
                echo "<td>" . $row["bestscore"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No results found</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
