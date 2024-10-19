<?php
// Connect to the database
$connection = new mysqli("localhost", "root", "", "medivault");

if (isset($_GET['id'])) {
    $id = $_GET['id'];  // Get the ID from the URL

    // Check if the ID is valid
    if (!empty($id)) {
        // Prepare the SQL query
        $sql = "DELETE FROM appointments WHERE appointmentID = $id";

       // Execute the query
        if ($connection->query($sql) === TRUE) {
            echo "<script>alert('Appointment deleted successfully');</script>";
        } else {
            echo "<script>alert('Error deleting record: " . $conn->error."');</script>";
        }
    } else {
        echo "<script>alert('Invalid ID.');</script>";
    }
} else {
    echo "<script>alert('No appointment ID provided.');</script>";
}

// Redirect back to the appointments page
$connection->close();
?>
