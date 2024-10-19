<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'medivault');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// Retrieve form data

$insuranceProvider = $_POST['insuranceProvider'];
$policyNumber = $_POST['policyNumber'];
$coverageDetails = $_POST['coverageDetails'];

// Insert data into the database
$sql = "INSERT INTO insurance ( insuranceProvider, policyNumber, coverageDetails)
 VALUES ('$insuranceProvider','$policyNumber','$coverageDetails')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('New record created successfully!');</script>";
} else {
    echo "<script>alert('Error: " . $sql . " " . $conn->error . "');</script>";

}

}
// Close the connection
$conn->close();
?>