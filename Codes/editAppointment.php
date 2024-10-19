<?php
// Connect to the database
$connection = new mysqli("localhost", "root", "", "medivault");

$id = $_GET['id'];  // Get the ID from the URL

// Fetch the specific record
$result = $connection->query("SELECT * FROM appointments WHERE appointmentID = $id");
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Appointment</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="icon" href="MediVault.png" type="image/x-icon">

    </head>
    <body>
    <div id="booking" class="booking-container">

<form id="bookingForm" class="booking-form" action="updateAppointment.php" method="POST">
    <h2>Edit Appointment</h2>
    <input type="hidden" name="appointmentID" value="<?php echo $row['appointmentID']; ?>" />
    
    <div class="input-group-book">
    Name: <input type="text" name="appointmentFirstName" value="<?php echo $row['appointmentFirstName']; ?>" /><br>
    </div>
    <div class="input-group-book">
    Identity Number: <input type="text" name="IDNum" value="<?php echo $row['IDNum']; ?>" /><br>
    </div>
    <div class="input-group-book">
    Details: <input type="text" name="appointmentDetails" value="<?php echo $row['appointmentDetails']; ?>" /><br>
   </div>
    <div class="input-group-book">
    Appointment Time: <input type="time" name="appointmentTime" value="<?php echo$row['appointmentTime']; ?>" /><br>
    </div>
    <div class="input-group-book">
    Appointment Date: <input type="date" name="appointmentDate" value="<?php echo$row['appointmentDate']; ?>" /><br>
    </div>
    <button type="submit">Update Appointment</button> 

</form>
</div>
</body>
</html>