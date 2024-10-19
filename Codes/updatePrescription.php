<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "medivault");

  // Get form data
  $medicationName = $_POST['medicationName'];
  $medicationPurpose = $_POST['medicationPurpose'];
  $medicationDosage = $_POST['medicationDosage'];
  $medicationFrequency = $_POST['medicationFrequency'];
  $physicianSignature = $_POST['physicianSignature'];
  $prescriptionID = $_POST['prescriptionID'];
  $IDNum =  $_POST['IDNum'];


   // Remove the "data:image/png;base64," part and decode the signature
   $signatureData = base64_encode(preg_replace('#^data:image/\w+;base64,#i', '', $physicianSignature));



   // Prepare the SQL statement with placeholders
   $sql = "UPDATE prescriptions 
           SET medicationName = ?, 
           medicationPurpose = ?,
            medicationDosage = ?, 
            medicationFrequency = ?,
             physicianSignature = ? ,
             IDNum = ? 
           WHERE prescriptionID = ?";
   
   // Prepare and bind parameters
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("sssssi", $medicationName, $medicationPurpose, $medicationDosage, $medicationFrequency, $signatureData, $prescriptionID);
   
   // Execute the update statement
   $stmt->execute();
   
   if ($stmt->affected_rows > 0) {
    echo "<script>alert('Prescription updated successfully');window.history.back();</script>";
} else {
    echo "<script>alert('Error updating record: " . $conn->error."');window.history.back();</script>";
}

// Redirect back to the appointments page
$conn->close();
?>