<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "medivault");

$id = $_POST['appointmentID'];
$firstName = $_POST['appointmentFirstName'];
$date = $_POST['appointmentDate'];
$time = $_POST['appointmentTime'];
$details = $_POST['appointmentDetails'];
$IDNum =  $_POST['IDNum'];



// Update query
$sql = "UPDATE appointments SET 
            appointmentFirstName = '$firstName', 
            appointmentDate = '$date', 
            appointmentTime = '$time', 
            appointmentDetails = '$details' 
            IDNum = '$IDNum'
        WHERE appointmentID = $id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Appointment updated successfully');window.history.back();</script>";
} else {
    echo "<script>alert('Error updating record: " . $conn->error."');window.history.back();</script>";
}

// Redirect back to the appointments page
$conn->close();
?>
