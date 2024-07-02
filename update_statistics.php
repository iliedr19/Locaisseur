<?php
// Database connection
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

// Get score from the request body
$data = json_decode(file_get_contents('php://input'), true);
$score = $data['score'];

// Get user's username from the session or request, assuming you have it available
$username = $_SESSION["username"]; 

// Update user statistics
$sql = "UPDATE user 
        SET roundsplayed = roundsplayed + 1, 
            totalscore = totalscore + '$score',
            avgscore = totalscore / roundsplayed,
            bestscore = CASE 
                            WHEN '$score' > bestscore THEN '$score'
                            ELSE bestscore 
                        END 
        WHERE username = '$username'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("message" => "User statistics updated successfully"));
} else {
    echo json_encode(array("error" => "Error updating user statistics: " . $conn->error));
}

$conn->close();
?>
