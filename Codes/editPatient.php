<?php
// Connect to the database
$connection = new mysqli("localhost", "root", "", "medivault");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "<script>alert('Error: No ID provided.'); </script>";
    exit();
}

// Fetch the specific record
$result = $connection->query("SELECT * FROM patients WHERE patientID = $id");
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Patient</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="icon" href="MediVault.png" type="image/x-icon">

    </head>
    <body>
    <div class="register-patient-container">
                <form class="register-patient-form" action="updatePatient.php" method="POST" >
                <h2>Register a Patient</h2>
                <input type="hidden" name="patientID" value="<?php echo $row['patientID']; ?>" />

                  <div class="input-group-book">
                     <label for="patientFirstName">First name</label>
                     <input type="text" id="patientFirstName" name="firstName" value="<?php echo $row['firstName']; ?>" >
                   </div>  
                    <div class="input-group-book">
                     <label for="patientLastName">Last Name</label>
                    <input type="text" id="patientLastName" name="lastName" value="<?php echo $row['lastName']; ?>" >
                 </div>
                 <div class="input-group-book">
                     <label for="patientIDNum">Identity Number</label>
                    <input type="text" id="patientIDNUM" name="IDNum" value="<?php echo $row['IDNum']; ?>" >
                 </div>
                    <fieldset>
                    <legend> Gender</legend>
                    <label for="patientGender"><input type="radio" id="gender" name="gender" value="m" <?php if ($row['gender'] == 'm') echo 'checked'; ?> required>Male</label> <br>
                    <label for="patientGender"><input type="radio" id="gender" name="gender" value="f" <?php if ($row['gender'] == 'f') echo 'checked'; ?> >Female</label>
                    </fieldset>
                                        
                                <div class="input-group-book">
                                    <label for="pastConditions">Past Conditions</label>
                                    <input type="text" id="pastConditions" name="pastConditions" value="<?php echo $row['pastConditions']; ?>" >
                                </div>
                                <div class="input-group-book">
                                    <label for="allergies">Allergies</label>
                                    <input type="text" id="allergies" name="allergies" value="<?php echo $row['allergies']; ?>" >
                                </div>
                                <div class="input-group-book">  
                                    <label for="familyMedicalHistory">Family Medical History</label>
                                    <input type="text" id="familyMedicalHistory" name="familyMedicalHistory" value="<?php echo $row['familyMedicalHistory']; ?>" >
                                </div>
                                <div class="input-group-book">
                                    <label for="BP">BP</label>
                                    <input type="text" id="BP" name="BP" value="<?php echo $row['BP']; ?>" >
                                </div>
                                <div class="input-group-book">
                                    <label for="heartrate">Heartrate</label>
                                    <input type="text" id="heartrate" name="heartrate" value="<?php echo $row['heartrate']; ?>" >
                                </div>
                                <div class="input-group-book">
                                    <label for="temperature">Temperature</label>
                                    <input type="text" id="temperature" name="temperature" value="<?php echo $row['temperature']; ?>" >
                                </div>
                                <div class="input-group-book">
                                    <label for="respiratoryRate">Respiratory Rate</label>
                                    <input type="text" id="respiratoryRate" name="respiratoryRate" value="<?php echo $row['respiratoryRate']; ?>" >
                                </div>

                                <button type="submit">Register Patient</button>
                            </form>
                        </div>
</body>
</html>