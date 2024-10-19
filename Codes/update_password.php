<?php

// db_connect.php

$servername = "localhost"; // Your server name
$username = "root";        // Your MySQL username
$password = "";            // Your MySQL password (or any password you set)
$dbname = "medivault";      // Your database name

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email']; // Get the email passed from the form
    $new_password = $_POST['new_password'];

    // Hash the new password for security
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Prepare an SQL statement to update the password
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $email);

    // Execute the query
    if ($stmt->execute()) {
        // Success, redirect to the login page or show a success message
        echo "<script>alert('Password updated successfully. You can now log in with your new password.'); window.location.href='login.html';</script>";
    } else {
        // Error occurred, show an error message
        echo "<script>alert('Error updating password. Please try again.'); window.location.href='newpassword.php?email=" . urlencode($email) . "';</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
