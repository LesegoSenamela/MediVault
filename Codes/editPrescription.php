<?php
// Connect to the database
$connection = new mysqli("localhost", "root", "", "medivault");

$id = $_GET['id'];  // Get the ID from the URL

// Fetch the specific record
$result = $connection->query("SELECT * FROM prescriptions WHERE prescriptionID = $id");
$row = $result->fetch_assoc();

// Convert the BLOB to a base64 string
$signatureBlob = base64_encode($row['physicianSignature']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Prescription</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="MediVault.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
</head>
<body>
    <div class="prescription-container">
        <form id="prescription" class="prescription-form" action="updatePrescription.php" method="POST">
            <h2>Prescription Form</h2>
            <input type="hidden" name="prescriptionID" value="<?php echo $row['prescriptionID']; ?>" />

            <div class="input-group-book">
                <input type="text" name="IDNum" value="<?php echo $row['IDNum']; ?>">
            </div>
            <div class="input-group-book">
                <input type="text" name="medicationName" value="<?php echo $row['medicationName']; ?>">
            </div>
            <div class="input-group-book">
                <input type="text" name="medicationPurpose" value="<?php echo $row['medicationPurpose']; ?>">  
            </div>
            <div class="input-group-book">
                <input type="text" name="medicationDosage" value="<?php echo $row['medicationDosage']; ?>">   
            </div>
            <div class="input-group-book">
                <input type="text" name="medicationFrequency" value="<?php echo $row['medicationFrequency']; ?>">  
            </div>

            <div id="signature-form" class="input-group-book">
                <label for="physician-signature" >Physician Signature</label>
                <div class="sign_container">
                    <canvas id="signature-pad" width="700" height="200" style="border:1px solid #000"></canvas>
                    <div class="signButton">

                        <button id="clear-button">Clear</button>
                    </div>

                </div>
                <!-- Pass the base64 signature to JavaScript -->
                <input type="hidden" id="signatureBlob" name="physicianSignature" value="<?php echo $signatureBlob; ?>">
            </div>

            <button type="submit">Submit Prescription</button>
        </form>
    </div>

    <script>
        // Get the base64 signature data from the hidden input field
        const signatureBlob = document.getElementById('signatureBlob').value;

        // If there is a signature, convert it back to an image and draw it on the canvas
        if (signatureBlob) {
            const canvas = document.getElementById('signature-pad');
            const ctx = canvas.getContext('2d');

            const img = new Image();
            img.src = 'data:image/png;base64,' + signatureBlob;

            // Draw the image onto the canvas once it's loaded
            img.onload = function() {
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            };
        }

        // Clear button functionality to clear the canvas
        document.getElementById('clear-button').addEventListener('click', function(event) {
            event.preventDefault();
            const canvas = document.getElementById('signature-pad');
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        });
        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas);

        // Clear the signature pad
        document.getElementById('clear-button').addEventListener('click', function () {
            signaturePad.clear();
        });

        
    </script>
</body>
</html>
