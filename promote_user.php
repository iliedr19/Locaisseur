<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "licenta";

    session_start();

    if (!isset($_SESSION["username"])) {
        header("Location: manage_users.php");
        exit();
    }

    // Create a connection
    $conn = new mysqli($server, $username, $password, $dbname);

    $usertopromote = $_GET["username"];

    $query = "UPDATE User SET isadmin = 1 WHERE username = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Bind the parameters and execute the statement
        $stmt->bind_param("s", $usertopromote);
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->affected_rows > 0) {
            // User promoted successfully
            header("Location: manage_users.php");
            exit();
        } else {
            // Error occurred while promoting user
            header("Location: manage_users.php?error=promote_failed");
            exit();
        }
    } else {
        // Error occurred while preparing the statement
        header("Location: manage_users.php?error=promote_failed");
        exit();
    }
?>
