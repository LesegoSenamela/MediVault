<?php
session_start();
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'medivault');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];
$address = $_POST['address'];
$firstName =$_POST['firstName'];
$lastName = $_POST['lastName'];
$contactNO = $_POST['contactNO'];
$email = $_POST['email'];
$IDNum = $_POST['IDNum'];

// Use $hashed_password in the INSERT query
$hashed_password = password_hash($password, PASSWORD_DEFAULT);


// Insert data into the database
$sql = "INSERT INTO users (username, password, role, address, firstName, lastName, contactNO, email, IDNum) VALUES ('$username', '$hashed_password', '$role', '$address', '$firstName', '$lastName', '$contactNO', '$email', '$IDNum')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('New record created successfully!');</script>";
} else {
    echo "<script>alert('Error: " . $sql . " " . $conn->error . "');</script>";
}

// Query to check user credentials
$sql = "SELECT * FROM users WHERE username='$username'  AND role='$role'";
$result = $conn->query($sql);

// Check if user exists
if ($result->num_rows > 0) {
    // User exists, store their role in session
    $_SESSION['role'] = $role;

    // Redirect based on role
    if ($role == 'doctor') {
        header("Location: doctornew.php");
    } elseif ($role == 'nurse') {
        header("Location: nurse.php");
    } elseif ($role == 'admin') {
        header("Location: admin.php");
    } elseif ($role == 'patient') {
        header("Location: patient.php");
    }elseif ($role == 'pharmacy') {
        header("Location: pharmacy.php");
    }
} else {
    echo "<script>alert('Invalid credentials or role!');</script>";
}
}
// Close the connection
$conn->close();
?>
