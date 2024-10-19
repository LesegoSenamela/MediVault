<?php
session_start();

// Database connection (ensure you set these variables according to your DB setup)
$host = 'localhost';
$dbname = 'medivault';
$username = 'root';
$password = '';
$connection = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
$holidays = [
    '2024-01-01', // New Year's Day
    '2024-12-25',// Christmas
    '2024-12-26',
    '2024-12-16',
    '2024-09-24',
    '2024-08-09',
    '2024-06-16',
    '2024-05-01',
    '2024-04-27',
    '2024-04-01',
    '2024-03-29',//good friday
    '2024-03-21'

    // Add more holidays as needed
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $date = $_POST['appointmentDate'];
    $time = $_POST['appointmentTime'];
    $details = $_POST['appointmentDetails'];
    $firstName = $_POST ['appointmentFirstName'];
    $lastName = $_POST ['appointmentLastName'];
    $IDNum = $_POST['IDNum'];

    $dayOfWeek = date('N', strtotime($date)); // 1 (for Monday) through 7 (for Sunday)
    if ($dayOfWeek >= 6) { // If Saturday (6) or Sunday (7)
        echo "<script>alert('Please choose a weekday for your appointment (Monday to Friday).'); window.history.back();</script>";
        exit;
    }

    // Check if the chosen date is a holiday
    if (in_array($date, $holidays)) {
        echo "<script>alert('The selected date is a holiday. Please choose another date.');window.history.back();</script>";
        exit;
    }    

    $working_hours_start = "07:00";
    $working_hours_end = "17:00";

    // Convert input time to a comparable format
    if ($time < $working_hours_start || $time >= $working_hours_end) {
        echo "<script>alert('Please choose a time during working hours (07:00 AM to 05:00 PM).'); window.history.back();</script>";
        exit;
    }

    // Check if the chosen time slot is available
    $query = "SELECT * FROM appointments WHERE appointmentDate = ? AND appointmentTime = ?";
    $stmt = $connection->prepare($query); // Updated to use $connection
    $stmt->bind_param("ss", $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('This time slot has already been booked. Please choose another time.'); window.history.back();</script>";
        exit;
    }

    // Insert booking into the database
    $sql = "INSERT INTO appointments (appointmentDate, appointmentTime, appointmentDetails, appointmentFirstName, appointmentLastName, IDNum) 
            VALUES ('$date', '$time', '$details', '$firstName','$lastName','$IDNum')";

    if ($connection->query($sql) === TRUE) {
        echo "<script>alert('Appointment booked successfully!');</script>";
        exit();
    } else {
        echo "<script>alert('Database error: " . $connection->error . "');</script>";
        exit();
    }

    
} else {
    echo "<script>alert('Invalid request.'); </script>";
}

// Close the connection
$connection->close();
?>
