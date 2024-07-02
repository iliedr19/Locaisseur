<?php

    session_start();

    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "licenta";

    $conn = new mysqli($server, $username, $password, $dbname);

    $usernameinput = $_POST["username"];
    $passwordinput = $_POST["password"];

    

    $querycurrentrealname = "SELECT realname FROM User WHERE username = '$usernameinput'";
    $resultcurrentrealname = $conn->query($querycurrentrealname);
    $row = $resultcurrentrealname->fetch_assoc();
    $current_realname = $row['realname'];

    $querycurrentisadmin = "SELECT isadmin FROM User WHERE username = '$usernameinput'";
    $resultcurrentisadmin = $conn->query($querycurrentisadmin);
    $row = $resultcurrentisadmin->fetch_assoc();
    $current_isadmin = $row['isadmin'];

    $querycurrentpassword = "SELECT password FROM User WHERE username = '$usernameinput'";
    $resultcurrentpassword = $conn->query($querycurrentpassword);
    $row = $resultcurrentpassword->fetch_assoc();
    $current_password = $row['password'];

    if ($passwordinput==$current_password) {
        $_SESSION["username"] = $usernameinput;
        $_SESSION["isadmin"] = $current_isadmin;
        $_SESSION["realname"] = $current_realname;
        header("Location: main_page.php");
        exit();
    } else {
        header("Location: index.php");
        exit();
    }

?>