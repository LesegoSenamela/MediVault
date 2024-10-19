<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'medivault');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// Retrieve form data
$gender = $_POST['gender'];
$pastConditions = $_POST['pastConditions'];
$allergies = $_POST['allergies']; 
$familyMedicalHistory = $_POST['familyMedicalHistory'];
$BP = $_POST['BP']; 
$heartrate = $_POST['heartrate'];
$temperature = $_POST['temperature'];
$respiratoryRate = $_POST['respiratoryRate'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$IDNum = $_POST['IDNum'];


// Insert data into the database
$sql = "INSERT INTO patients ( firstName, lastName, gender, pastConditions, allergies, familyMedicalHistory, BP, heartrate, temperature , respiratoryRate, IDNum)
 VALUES ('$firstName','$lastName','$gender','$pastConditions','$allergies','$familyMedicalHistory','$BP', '$heartrate', '$temperature','$respiratoryRate', '$IDNum')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('New record created successfully!');</script>";
} else {
    echo "<script>alert('Error: " . $sql . " " . $conn->error . "');</script>";

}
}
// Close the connection
$conn->close();
?>