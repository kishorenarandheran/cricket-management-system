<?php
session_start();
// Database connection
$con = mysqli_connect("localhost", "root", "", "cricket");

// Check connection
if (mysqli_connect_errno()) {
    // Redirect with error message if connection fails
    header("Location: rank.php?status=error&message=" . urlencode("Database connection failed: " . mysqli_connect_error()));
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $runs = $_POST['runs'];
    $wickets = $_POST['wickets'];
    $no_of_matches = $_POST['no_of_matches'];
    
    // Check if player exists
    $check_query = "SELECT * FROM player WHERE playername='$name'";
    $result = mysqli_query($con, $check_query);
    
    if(mysqli_num_rows($result) > 0) {
        // Player exists, update their stats
        $q = "UPDATE player SET runs='$runs', wickets='$wickets', no_of_matches='$no_of_matches' WHERE playername='$name'";
        
        if(mysqli_query($con, $q)) {
            // Success - redirect with success message
            header("Location: rank.php?status=success&message=" . urlencode("Player stats for '$name' updated successfully!"));
            exit();
        } else {
            // Error in update query
            header("Location: rank.php?status=error&message=" . urlencode("Error updating player: " . mysqli_error($con)));
            exit();
        }
    } else {
        // Player doesn't exist
        header("Location: rank.php?status=error&message=" . urlencode("Player not found: $name"));
        exit();
    }
} else {
    // Not a POST request
    header("Location: rank.php");
    exit();
}

// Close connection
mysqli_close($con);
?>
//2