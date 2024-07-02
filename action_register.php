<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "licenta";

// Create a MySQLi instance
$conn = new mysqli($servername, $username, $password, $dbname);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $queryusernameunique="SELECT * FROM user WHERE username='$username'";
    $resultusernameunique=$conn->query($queryusernameunique);

    $password = $_POST['password'];
    $realname = $_POST['realname'];

    if($resultusernameunique->num_rows==0){
        $sql = "INSERT INTO user (username, password, realname) VALUES ('$username', '$password', '$realname')";
        if ($conn->query($sql) === true) {
            $_SESSION["username"] = $username;
            $_SESSION["realname"] = $realname;
            
            $querycurrentisadmin = "SELECT isadmin FROM user WHERE username = '$username'";
            $resultcurrentisadmin = $conn->query($querycurrentisadmin);
            $row = $resultcurrentisadmin->fetch_assoc();
            $current_isadmin = $row['isadmin'];

            $_SESSION["isadmin"] = $current_isadmin;
            header("Location: main_page.php");
            exit();
        } else {
            header("Location: register.php");
            exit();
        }
    }
    else{
        header("Location: register.php");
        exit();
    }
}

// Close the database connection
$conn->close();
?>