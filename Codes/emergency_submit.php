<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'medivault');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// Retrieve form data

$contactName = $_POST['contactName'];
$contactNO = $_POST['contactNO'];
$relationship = $_POST['relationship'];


// Insert data into the database
$sql = "INSERT INTO emergency_contact ( contactName, relationship, contactNO)
 VALUES ('$contactName','$relationship','$contactNO')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('New record created successfully!');</script>";
} else {
    echo "<script>alert('Error: " . $sql . " " . $conn->error . "');</script>";

}

}
// Close the connection
$conn->close();
?>