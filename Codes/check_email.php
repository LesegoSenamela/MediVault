<?php

// db_connect.php

$servername = "localhost"; // Change this if your database server is different
$username = "root";        // Change this to your MySQL username
$password = "";            // Change this to your MySQL password
$dbname = "MediVault";      // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists, redirect to the new password page
        header("Location: newpassword.php?email=" . urlencode($email));
        exit();
    } else {
        // Email doesn't exist, show error message
        echo "<script>alert('Email not found. Please try again.'); window.location.href='forgotpassword.html';</script>";
    }
}
?>
