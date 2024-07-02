<!DOCTYPE html>
<html>
<head>
    <title>Locaisseur</title>
    <style>
        body {
            background-color: #333;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
        }
        
        h1 {
            text-align: center;
            margin-top: 100px;
            font-size: 24px;
            color: #fff;
        }
        
        form {
            text-align: center;
            margin-top: 20px;
        }
        
        input[type="text"], input[type="password"] {
            width: 200px;
            height: 30px;
            margin: 5px;
            padding: 5px;
            border: 1px solid #888;
            border-radius: 4px;
            outline: none;
            background-color: #444;
            color: #fff;
        }
        
        input[type="submit"] {
            width: 100px;
            height: 35px;
            margin-top: 10px;
            background-color: #888;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .register-button, .main-page-button {
            display: block;
            text-align: center;
            font-size: 16px;
            background-color: #888;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            padding: 8px 16px;
            position: absolute;
        }
        
        .register-button {
            top: 0;
            right: 0;
        }
        
        .main-page-button {
            top: 0;
            left: 0;
        }
        
        .main-page-button:hover, .register-button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h1>EXPLORE THE WORLD!<br>Get dropped anywhere from the busy streets of Slatinita to the beautiful beaches of Costinesti.<br><br><br></h1>
    <a href="main_page.php" class="main-page-button">Menu</a>
    <a href="register.php" class="register-button">Register</a>
    <form action="action_login.php" method="POST">
        <input type="text" placeholder="Username" name="username">
        <br>
        <input type="password" placeholder="Password" name="password">
        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
