<?php
// Database connection
$servername = "localhost"; // Update if necessary
$username = "root"; // Update with your MySQL username
$password = ""; // Update with your MySQL password
$dbname = "medivault"; // Update with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $IDNum = $_POST['IDNum'];
    $medicationName = $_POST['medicationName'];
    $medicationPurpose = $_POST['medicationPurpose'];
    $medicationDosage = $_POST['medicationDosage'];
    $medicationFrequency = $_POST['medicationFrequency'];
    $physicianSignature = $_POST['physicianSignature'];

     // Remove the "data:image/png;base64," part and decode the signature
     $signatureData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $physicianSignature));

    // Insert data into the database

   // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO prescriptions ( IDNum, medicationName, medicationPurpose, medicationDosage, medicationFrequency, physicianSignature) 
            VALUES (?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);

   

    // Bind parameters
    $stmt->bind_param("ssssss", $IDNum,$medicationName, $medicationPurpose, $medicationDosage, $medicationFrequency, $signatureData);



    
     if ($stmt->execute()) {
         echo json_encode(['success' => true]);
     } else {
         echo json_encode(['success' => false, 'error' => $stmt->error]);
     }
   
     $stmt->close();
}

// Close the connection
$conn->close();
?>
