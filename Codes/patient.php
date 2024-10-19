<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Patient</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="icon" href="MediVault.png" type="image/x-icon">

    </head>
    <body>
<section style="display: flex;">
    <div class="side-bar">
        <div id="doctor-info">
            <img src="icon.png" alt="Profile Picture">
            <h2>Patient Information</h2>
            <p>Welcome,  </p>
            <button class="sign-out" onclick="logout()">Log out</button>
            <div class="solid-line"></div>
        </div>
        <nav>
            <a href="#" data-content="dashboard" class="active"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
            <a href="#" data-content="bookings"><i class="fas fa-calendar-check"></i>Bookings</a>
            <a href="#" data-content="prescriptions"><i class="fas fa-prescription-bottle-alt"></i>Prescriptions</a>
            <a href="#" data-content="medicalRecords"><i class="fas fa-file-medical"></i>Medical Records</a>
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
                <option value="bookings">Bookings</option>
                <option value="medications">Prescriptions</option>
            </select>
            <input type="text" id="searchQuery" placeholder="Search...">
            <button type="submit" class="search-button" onclick="performSearch()"><i class="fas fa-search"></i></button>
            </div>
            <ul id="searchResults"></ul>


            <div class="dashboard-reminders">
                <div class="left-section">
           
                <div class="reminder" id="general-reminders"></div>
                </div>
                <div class="reminder">
            <h2>Recent Bookings</h2>
            <ul id="recentBookings">
            <?php

// Create connection
$conn = new mysqli("localhost", "root", "", "medivault");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch recent bookings from the appointments table
$sql = "SELECT  appointmentFirstName,appointmentLastName,appointmentDate,appointmentTime,appointmentDetails FROM appointments ORDER BY appointmentDate DESC LIMIT 5"; // Adjust the column names and table name as needed
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output the recent bookings
    while ($row = $result->fetch_assoc()) {
        echo '<li>'. $row["appointmentFirstName"] ." , ". $row["appointmentDate"] . " , ". $row["appointmentTime"] . " , ".  $row["appointmentDetails"] . '</li>';
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
        <div id="medicalRecords" class="content-section">
            <h1>Medical Records</h1>
            <section>
			<!--medicalRecords-->
            <div class="medicalrecords">
                <ul id="recordsList"></ul>
            </div>
            </section>
        </div>
        <div id="bookings" class="content-section" >
            <h1>Bookings</h1>
			<!--add booking appointment form-->
			<div id="booking" class="booking-container">
                    <form id="bookingForm" class="booking-form" action="submit_booking.php" method="POST" >
                    <div class="input-group-book" >
                    <label for="date">First Name</label>
                    <input type="text" id="name" name="appointmentFirstName" placeholder="Fill Here......" required>
                </div>
                <div class="input-group-book" >
                    <label for="date">Last Name</label>
                    <input type="text" id="name" name="appointmentLastName" placeholder="Fill Here......" required>
                </div>
                <div class="input-group-book" >
                    <label for="date">Identity Number</label>
                    <input type="text" id="ID" name="IDNum" placeholder="Fill Here......" required>
                </div>
                <div class="input-group-book" >
                    <label for="date">Date</label>
                    <input type="date" id="date" name="appointmentDate" required>
                </div>
                <div class="input-group-book" >
                    <label for="time">Time</label>
                    <input type="time" id="time" name="appointmentTime" required>
                </div>
                <div class="input-group-book">
                    <label for="details">Details</label>
                    <textarea id="details" name="appointmentDetails" rows="4" placeholder="Fill Here......" required></textarea>
                </div>
               
                    <button type="submit">Book Appointment</button>
                
            </form>
			</div>
            

            <div id="appointments" class="appointments-list">
                <h2>Appointments</h2>
                <ul>
    <?php
    $conn = new mysqli('localhost', 'root', '', 'medivault');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    };

    $sql = "SELECT * FROM appointments";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $index = 0;
            echo "<li>";
            echo "<div><strong>First Name:</strong> " . $row["appointmentFirstName"] . "</div>";
            echo "<div><strong>Last Name:</strong> " . $row["appointmentLastName"] . "</div>";
            echo "<div><strong>Date:</strong> " . $row["appointmentDate"] . "</div>";
            echo "<div><strong>Time:</strong> " . $row["appointmentTime"] . "</div>";
            echo "<div><strong>Details:</strong> " . $row["appointmentDetails"] . "</div>";
            echo "<div><strong>Actions:</strong> 
                        <button onclick=\"editAppointment('" .$row['appointmentID']. "')\" class=\"edit-button\">Edit</button>
                        <button onclick=\"deleteAppointment('" .$row['appointmentID']. "')\" class=\"delete-button\">Delete</button>
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
       
        <div id="prescriptions" class="content-section">
                           
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
           

            echo "<div class='prescription-right'>";
            echo "<img src='data:image/png;base64," . $imageData . "' alt='Prescription Signature' style='width: 100px; height: auto;'>";
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
        </div>
        <div id="settings" class="content-section">
            <h1>Settings</h1>
          
            <!-- Emergency Contact and Insurance Form -->
            <h2>Emergency Contact & Insurance Information</h2>
            <form id="emergencyForm" class="settings-form" action="emergency_submit.php" method="POST">
                <!-- Emergency Contact Details -->
                <h3>Emergency Contact</h3>
                <div class="input-group-book">
                    <label for="emergencyContactName">Name</label>
                    <input type="text" id="emergencyContactName" name="contactName" required>
                </div>
                <div class="input-group-book">
                    <label for="emergencyContactPhone">Phone Number</label>
                    <input type="tel" id="emergencyContactPhone" name="contactNO" required>
                </div>
                <div class="input-group-book">
                    <label for="relationship">Relationship</label>
                    <input type="text" id="relationship" name="relationship" required>
                </div>
                <button type="submit">Save Information</button>
                
                 </form>
                <!-- Insurance Information --> 
                 <form id="InsuranceForm" class="settings-form" action="submit_insurance.php" method="POST">
                <h3>Insurance Information</h3>
                <div class="input-group-book">
                    <label for="insuranceProvider">Insurance Provider</label>
                    <input type="text" id="insuranceProvider" name="insuranceProvider" required>
                </div>
                <div class="input-group-book">
                    <label for="policyNumber">Policy Number</label>
                    <input type="text" id="policyNumber" name="policyNumber" required>
                </div>
                <div class="input-group-book">
                    <label for="coverageDetails">Coverage Details</label>
                    <textarea id="coverDetails"  name="coverageDetails" rows="3" required></textarea>
                </div>
                <button type="submit">Save Information</button>
            </form>

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
// Load dashboard data
document.addEventListener("DOMContentLoaded", function() {
    const patientCount = document.getElementById("patient-count").querySelector("p");
    const appointmentCount = document.getElementById("appointment-count").querySelector("p");
    const prescriptionCount = document.getElementById("prescription-count").querySelector("p");
    const appointmentsList = document.getElementById("appointmentsList");
    const recentPrescriptionsList = document.getElementById("recentPrescriptionsList");

   
    // Update dashboard metrics
    patientCount.textContent = patients;
    appointmentCount.textContent = appointments.length;
    prescriptionCount.textContent = prescriptions.length;

    // Update appointments list
    appointments.forEach(appointment => {
        const listItem = document.createElement("li");
        listItem.textContent = `${appointment.date} at ${appointment.time} - ${appointment.patient}`;
        appointmentsList.appendChild(listItem);
    });

    // Update recent prescriptions list
    prescriptions.slice(-5).forEach(prescription => {
        const listItem = document.createElement("li");
        listItem.textContent = `Patient: ${prescription.patientName}, Medication: ${prescription.medication}, Dosage: ${prescription.dosage}, Prescribed by: Dr. ${prescription.doctorName}`;
        recentPrescriptionsList.appendChild(listItem);
    });
}); 

// Assume patient data is fetched from database or API
const patientData = {
    
    reminders: [
      'Remember to bring medical records to the appointment',
      'Schedule a follow-up consultation',
    ],
  };

  function updateReminders() {

    const generalReminders = document.getElementById('general-reminders');

   

    if (patientData.reminders.length > 0) {
      generalReminders.innerHTML = `
        <h2>Reminders:</h2>
        <ul>
          ${patientData.reminders.map((reminder) => `<li>${reminder}</li>`).join('')}
        </ul>
      `;
    } else {
      generalReminders.innerHTML = 'No reminders';
    }
  }

  updateReminders();
/////////////////////////////////////////////////////////////////////////////////
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
////////////////////////////////////search records/////////////////////
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
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////shortcuts////////////////////////
function navigateToSection(sectionId) {
    document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
    document.querySelectorAll('.side-bar nav a').forEach(a => a.classList.remove('active'));
    document.querySelector(`.side-bar nav a[data-content="${sectionId}"]`).classList.add('active');
}
////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////handle deleting
// Handle delete
function deleteAppointment(id) {
    if (confirm("Are you sure you want to delete this appointment?")) {
        window.location.href = 'deleteAppointment.php?id=' + id;  // Redirect to delete.php
    }
}

// Handle edit
function editAppointment(id) {
    window.location.href = 'editAppointment.php?id=' + id;  // Redirect to edit.php
}

/////////////////////////////////////////////////////////////////////////////////////
</script>
    </body>
</html>