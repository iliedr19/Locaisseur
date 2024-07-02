


<!DOCTYPE html>
<html>
<head>
    <title>Main Menu</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #555;
            color: #fff;
        }

        .header {
            background-color: #111;
            padding: 10px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .profile-container {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }

        .profile-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
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

        .menu {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .menu h2 {
            margin-bottom: 10px;
            color: #111;
        }

        .menu ul {
            list-style: none;
            padding: 0;
        }

        .menu ul li {
            margin-bottom: 10px;
        }

        .menu ul li a {
            display: inline-block;
            background-color: #111;
            color: #bbb;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .menu ul li a:hover {
            background-color: #333;
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
    </script>
</head>
<body>
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

    <div class="header">
        <div class="user-info">
            <div class="user-details">
                <div class="user-name"><?php echo $realname; ?></div>
                <div class="dropdown">
                    <button class="dropdown-button"></button>
                    <div class="dropdown-content">
                        <a href="profile.php">Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="menu">
        <?php if ($isadmin == 1): ?>
            <h2>Administrate the App</h2>
            <ul>
                <li><a href="manage_users.php">Manage Users</a></li>
            </ul>
        <?php endif; ?>
        <h2>Enjoy The Game</h2>
        <ul>
            <li><a href="classical_game.php">Guess the random location on Google Street View</a></li>
            <li><a href="show_stats.php">Show statistics of everyone</a></li>
        </ul>
    </div>
</body>
</html>
