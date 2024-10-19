<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'medivault');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// Retrieve form data from the medication form
$medicationName = $_POST['medicationName'];
$quantity = $_POST['quantity'];

// Insert the data into the medications table
$sql = "INSERT INTO medications (name, quantity) VALUES ('$medicationName', $quantity)";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('New medication added successfully!');</script>";
} else {
    echo "<script>alert('Error: " . $sql . " " . $conn->error . "');</script>";
}

}

// Close the connection
$conn->close();
?>
