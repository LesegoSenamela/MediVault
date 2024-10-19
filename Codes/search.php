<?php
$filter = $_GET['filter'];
$query = $_GET['query'];

// Database connection (update with your credentials)
$conn = new mysqli('localhost', 'root', '', 'medivault');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$resultHTML = '';

switch ($filter) {
    case 'patients':
        $stmt = $conn->prepare("SELECT * FROM patients WHERE firstname LIKE ?");
        break;
    case 'bookings':
        $stmt = $conn->prepare("SELECT * FROM appointments WHERE appointmentFirstName LIKE ?");
        break;
    case 'medications':
        $stmt = $conn->prepare("SELECT * FROM prescriptions WHERE medicationName LIKE ?");
        break;
    default:
        echo "<script>alert('Invalid filter selected.'); window.history.back(); </script>";
        exit();
}

// Use prepared statements to prevent SQL injection
$searchTerm = "%$query%";
$stmt->bind_param('s', $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $resultHTML .= '<li>' . implode(' - ', $row) . '</li>';
    }
} else {
    $resultHTML = 'No results found';
}

echo $resultHTML;

$stmt->close();
$conn->close();
?>
