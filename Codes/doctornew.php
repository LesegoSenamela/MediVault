<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Doctor</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="icon" href="MediVault.png" type="image/x-icon">
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </head>
    <body>
<section style="display: flex;">
    <div class="side-bar">
        <div id="doctor-info">
            <img src="icon.png" alt="Profile Picture">
            <h2>Doctor Information</h2>
            <p id="email">Welcome,  </p>
       <button class="sign-out">Log out</button>
            <div class="solid-line"></div>
        </div>
        <nav>
            <a href="#" data-content="dashboard" class="active"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
            <a href="#" data-content="patients"><i class="fas fa-user-injured"></i>Patients</a>
            <a href="#" data-content="bookings"><i class="fas fa-calendar-check"></i>Bookings</a>
            <a href="#" data-content="prescriptions"><i class="fas fa-prescription-bottle-alt"></i>Prescriptions</a>
            <a href="#" data-content="settings"><i class="fas fa-cogs"></i>Settings</a>
        </nav>
    </div>
    <div class="main-content" >
        <header>
        </header>


        <div id="dashboard" class="content-section active">
            <h1>Welcome to MediVault</h1>
            <div class="search-container">
            <select id="searchFilter">
                <option value="patients">Patients</option>
                <option value="bookings">Bookings</option>
                <option value="medications">Prescriptions</option>
            </select>
            <input type="text" id="searchQuery" placeholder="Search...">
            <button type="submit" class="search-button" onclick="performSearch()"><i class="fas fa-search"></i></button>
            
            </div>
            <ul id="searchResults"></ul>


         <!-- Dashboard Metrics --> 
         <div class="dashboard-metrics">
                <div class="metric" id="patient-count">
                    <h2>Patients</h2>
                    <p id="patientCount">0</p>
                </div>
                <div class="metric" id="appointment-count">
                    <h2>Appointments</h2>
                    <p id="appointmentCount">0</p>
                </div>
                <div class="metric" id="prescription-count">
                    <h2>Prescriptions</h2>
                    <p id="prescriptionCount">0</p>
                </div>
            </div>

            <div class="quick-links">
            <!-- Charts Section -->
            <div class="left-section">
            <div class="chart-container" style="display: flex; justify-content: space-around;">
            <canvas id="myChart" width="400" height="200"></canvas>
            </div>
            </div>
            <div class="right-section">
            <h3>Recent Bookings</h3>
            <ul id="recentBookings">
            <?php

// Create connection
$conn = new mysqli("localhost", "root", "", "medivault");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch recent bookings from the appointments table
$sql = "SELECT  appointmentFirstName,appointmentLastName,appointmentDate,appointmentTime,appointmentDetails,IDNum FROM appointments ORDER BY appointmentDate DESC LIMIT 5"; // Adjust the column names and table name as needed
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output the recent bookings
    while ($row = $result->fetch_assoc()) {
        echo '<li>'. $row["appointmentFirstName"] ." ". $row["appointmentLastName"] . '<br>'. $row["IDNum"] .'<br>'. $row["appointmentDate"] . '<br>'.  $row["appointmentDetails"] . '</li>';
    }
} else {
    echo "<p>No recent bookings found.</p>";
}

$conn->close();
?>

            </ul>
            </div>
            
        </div>  
        </div>


        <div id="patients" class="content-section">
            
            <div id="patientList" class="patient-list">
                <h2>Patient List</h2>
                <ul>
        <?php
        $conn = new mysqli('localhost', 'root', '', 'medivault');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        };

        $sql = "SELECT patients.*, appointments.* FROM patients
                LEFT JOIN appointments ON patients.IDNum = appointments.IDNum
                UNION
                SELECT patients.*, appointments.*
                FROM appointments
                LEFT JOIN patients ON patients.IDNum = appointments.IDNum";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                $index = 0;
                echo "<li>";
                echo "<div><strong>First Name:</strong> " . $row["firstName"] . "</div>";
                echo "<div><strong>Last Name:</strong> " . $row["lastName"] . "</div>";
                echo "<div><strong>Gender:</strong> " . $row["gender"] . "</div>";
                echo "<div><strong>Past Conditions:</strong> " . $row["pastConditions"] . "</div>";
                echo "<div><strong>Allergies:</strong> " . $row["allergies"] . "</div>";
                echo "<div><strong>Family Medical History:</strong> " . $row["familyMedicalHistory"] . "</div>";
                echo "<div><strong>Symptoms:</strong> " . $row["symptoms"] . "</div>";
                echo "<div><strong>BP:</strong> " . $row["BP"] . "</div>";
                echo "<div><strong>Heart Rate:</strong> " . $row["heartrate"] . "</div>";
                echo "<div><strong>Temperature:</strong> " . $row["temperature"] . "</div>";
                echo "<div><strong>Respiratory Rate:</strong> " . $row["respiratoryRate"] . "</div>";
                echo "<div><strong>Appointment Date:</strong> " . $row["appointmentDate"] . "</div>";
                echo "<div><strong>Appointment Time:</strong> " . $row["appointmentTime"] . "</div>";
                echo "<div><strong>Appointment Details:</strong> " . $row["appointmentDetails"] . "</div>";
                echo "<div><strong>Actions:</strong> 
                        <button onclick=\"editPatient('" .$row['patientID']. "')\" class=\"edit-button\">Edit</button>
                        <button onclick=\"deletePatient('" .$row['patientID']. "')\" class=\"delete-button\">Delete</button>
                      </div>";
                echo "</li>";
                $index++;
            }
        } else {
            echo "<li>No data available</li>";
        }
        $conn->close();
        ?>
    </ul>                   
            </div>
            
        </div>
        <div id="bookings" class="content-section">
            <h1>Bookings</h1>

            <ul>
    <?php
    $conn = new mysqli('localhost', 'root', '', 'medivault');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    };

    $sql = "SELECT users.*, appointments.*
            FROM users
            LEFT JOIN appointments ON users.IDNum = appointments.IDNum
            UNION
            SELECT users.*, appointments.*
            FROM appointments
            LEFT JOIN users ON users.IDNum = appointments.IDNum";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<li>";
            echo "<div><strong>First Name:</strong> " . $row["firstName"] . "</div>";
            echo "<div><strong>Last Name:</strong> " . $row["lastName"] . "</div>";
            echo "<div><strong>Contact Number:</strong> " . $row["contactNO"] . "</div>";
            echo "<div><strong>Date:</strong> " . $row["appointmentDate"] . "</div>";
            echo "<div><strong>Time:</strong> " . $row["appointmentTime"] . "</div>";
            echo "<div><strong>Details:</strong> " . $row["appointmentDetails"] . "</div>";
            echo "</li>";
        }
    } else {
        echo "<li>No data available</li>";
    }
    $conn->close();
    ?>
</ul>

        </div>
       
        <div id="prescriptions" class="content-section">
            <h1>Prescriptions</h1>
            <section>
                <div class="prescription-container">
                    <form id="prescription" class="prescription-form" action="submit_prescription.php" method="POST">
                        <h2>Prescription Form</h2>
                        <div class="input-group-book">
                        <input type="text" name="IDNum" placeholder="Patient Identity Number" required>
                        </div>
                        <div class="input-group-book">
                        <input type="text" name="medicationName" placeholder="Medication name" required>
                        </div>
                        <div class="input-group-book">
                        <input type="text" name="medicationPurpose" placeholder="Medication purpose" required>  
                        </div>
                        <div class="input-group-book">
                        <input type="text" name="medicationDosage" placeholder="Medication dosage" required>   
                        </div>
                        <div class="input-group-book">
                        <input type="text" name="medicationFrequency" placeholder="Medication frequency" required>  
                        </div>
                        <div  id="signature-form" class="input-group-book">
                        <label for="physician-signature">Physician Signature</label>
                        <div class="sign_container">
                        <canvas id="signature-pad" width="700" height="200"></canvas>
                        <div class="signButton">
                        <button id="clear-button">Clear</button>
                        </div>
                        </div>
                        <input type="hidden" id="physician-signature" name="physicianSignature" required>
                        </div>
           
            <button type="submit">Submit Prescription</button>
                    </form>
                </div>
                <div id="prescriptionsListContainer" class="prescriptions-container">
                    <h2>Prescriptions</h2>
                    <ul>
    <?php
    $conn = new mysqli('localhost', 'root', '', 'medivault');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    };

    $sql = "SELECT * FROM prescriptions";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $index = 0;
            $signature = $row["physicianSignature"];  // The BLOB data for the signature

            // Convert the BLOB to Base64
            $imageData = base64_encode($signature);

            echo "<li class='prescription-item'>";
            echo "<div class='prescription-left'>";
            echo "<div><strong>Medication Name:</strong> " . $row["medicationName"] . "</div>";
            echo "<div><strong>Purpose:</strong> " . $row["medicationPurpose"] . "</div>";
            echo "<div><strong>Dosage:</strong> " . $row["medicationDosage"] . "</div>";
            echo "<div><strong>Frequency:</strong> " . $row["medicationFrequency"] . "</div>";
            echo "<div><strong>Actions:</strong> 
                <button onclick=\"editPrescription('" .$row['prescriptionID']. "')\" class=\"edit-button\">Edit</button>
                </div>";
            echo "</div>";  // Close left container
            echo "<div class='prescription-right'>";
            echo "<img src='data:image/png;base64," . $imageData . "' alt='Prescription Signature' style='width: 200px; height: 100px;'>";
            echo "</div>";  // Close right container
            echo "</li>";
            $index++;
        }
    } else {
        echo "<li>No data available</li>";
    }
    $conn->close();
    ?>
</ul>

                </div>
            </section>
        </div>
        <div id="settings" class="content-section">
            <h1>Settings</h1>
            <p>Adjust settings here.</p>
        </div>
    </div>
    </section>
 <footer>
    <p>&copy; 2024 MediVault. All rights reserved.</p>
</footer>
<script>
 
document.querySelectorAll('.side-bar nav a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                // Remove active class from all links
                document.querySelectorAll('.side-bar nav a').forEach(a => a.classList.remove('active'));
                // Hide all content sections
                document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                // Show the content section corresponding to the clicked link
                document.getElementById(this.getAttribute('data-content')).classList.add('active');
            });
        });

///////////////////////////////////////////confirmation for buttons
document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll("button");

    buttons.forEach(button => {
        button.addEventListener("click", function(event) {
            // Perform your button-specific action here
            const confirmed = confirm("Are you sure you want to proceed?");
            if (confirmed) {
                console.log(`${button.textContent} clicked and confirmed`);
            }
            else{
                event.preventDefault(); // Prevent the default action if the user cancels
            }
        });
    });
});
///////////////////////////////////////////////////////////////////////

    //////////////////////////dashboard//////////////////////////////////////
    const patientCountElement = document.getElementById('patientCount');
    const appointmentCountElement = document.getElementById('appointmentCount');
    const prescriptionCountElement = document.getElementById('prescriptionCount');

    // Function to update patient, appointment, and prescription counts
    function updateCounts(patientCount, appointmentCount, prescriptionCount) {
    // Update the HTML values for each section
    patientCountElement.textContent = patientCount;
    appointmentCountElement.textContent = appointmentCount;
    prescriptionCountElement.textContent = prescriptionCount;

    // Update the chart's data and re-render it
    myChart.data.datasets[0].data[0] = patientCount; // Update patient count in chart
    myChart.data.datasets[0].data[1] = appointmentCount; // Update appointment count in chart
    myChart.data.datasets[0].data[2] = prescriptionCount; // Update prescription count in chart
    myChart.update();
}


// Create the chart
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Patients', 'Appointments', 'Prescriptions'],
        datasets: [{
            label: 'Statistics',
            data: [0, 0, 0], // Initial values
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Example: dynamically update the counts for all sections
updateCounts(12, 8, 15);

////////////////////////////////////////////////////////////// 
///////////////////////////////logout/////////////////////////////////////////////
function logout() {
    // Perform logout by ending the session
    fetch('logout.php', { method: 'POST' })
        .then(response => {
            if (response.ok) {
                window.location.href = 'login.html';
            }
        });
}
/////////////////////////////////////////////////////////////////////
////////////////////////////////////////////signature-pad//////////////////////

 // Signature canvas setup
 var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas);

        // Clear the signature pad
        document.getElementById('clear-button').addEventListener('click', function () {
            signaturePad.clear();
        });

        
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////edit and delete////////////////////////

// Handle edit
function editPrescription(id) {
    window.location.href = 'editPrescription.php?id=' + id;  // Redirect to edit.php
}

/////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////search ///////////////////////////////////
function performSearch() {
    const filter = document.getElementById('searchFilter').value;
    const query = document.getElementById('searchQuery').value;

    // Basic validation
    if (query === '') {
        alert("Please enter a search query.");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('GET', `search.php?filter=${filter}&query=${query}`, true);
    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById('searchResults').innerHTML = this.responseText;
        }
    };
    xhr.send();
}
///////////////////////////////////////////////////////////////////////////////////

</script>
    </body>
</html>