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

    $usertodelete = $_GET["username"];

    // Prepare the DELETE statement
    $query = "DELETE FROM User WHERE username = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $usertodelete);
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->affected_rows > 0) {
            // User deleted successfully
            header("Location: manage_users.php");
            exit();
        } else {
            // Error occurred while deleting user
            header("Location: manage_users.php?error=delete_failed");
            exit();
        }
    } else {
        // Error occurred while preparing the statement
        header("Location: manage_users.php?error=delete_failed");
        exit();
    }
?>
