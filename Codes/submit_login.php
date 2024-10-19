<?php
session_start();
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'medivault');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];
// Use $hashed_password in the INSERT query



// Query to check user credentials
$sql = "SELECT * FROM users WHERE username='$username' AND role='$role'";
$result = $conn->query($sql);

// Check if user exists
if ($result->num_rows > 0) {
    // User exists, store their role in session
    
    $row = $result->fetch_assoc();
        // Redirect based on role
        $_SESSION['role'] = $role;
     if ($role == 'doctor') {
        header("Location: doctornew.php");
        exit();
    } elseif ($role == 'nurse') {
        header("Location: nurse.php");
        exit();
    } elseif ($role == 'patient') {
        header("Location: patient.php");
        exit();
    }elseif ($role == 'pharmacist') {
        header("Location: pharmacy.php");
        exit();
    }
    
   
    exit();
} else {
    echo "<script>alert('Invalid credentials or role!'); </script>";
}
}
// Close the connection
$conn->close();
?>
