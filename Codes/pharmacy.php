

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="MediVault.png" type="image/x-icon"> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>   
</head>
<body>
    <section style="display: flex;">
        <div class="side-bar">
            <div id="pharmacist-info">
                <img src="icon.png" alt="Profile Picture">
                <h2>Pharmacist Information</h2>
                <p>Welcome: </p>
                <button class="sign-out">Log out</button>
                <div class="solid-line"></div>
            </div>

            <nav>
                <a href="#" data-content="dashboard" class="active"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                <a href="#" data-content="medication-list"><i class="fas fa-pills"></i>Medication List</a>
                <a href="#" data-content="medication-availability"><i class="fas fa-check-circle"></i>Check Availability</a>
                <a href="#" data-content="provide-medication"><i class="fas fa-hand-holding-medical"></i>Provide Medication</a>
                <a href="#" data-content="settings"><i class="fas fa-cogs"></i>Settings</a>
            </nav>
        </div>
        <div class="main-content">
            <header>
                
            </header>
    
            <div id="dashboard" class="content-section active">
                <h1>Welcome to the Pharmacy</h1>
                <div class="search-container">
                    <select id="searchFilter">
                        <option value="medications">Prescriptions</option>
                    </select>
                    <input type="text" id="searchQuery" placeholder="Search...">
                    <button type="submit" class="search-button" onclick="performSearch()"><i class="fas fa-search"></i></button>
                    </div>
                    <ul id="searchResults"></ul>

                <div class="dashboard-metrics">
                    <div class="metric" id="medication-count">
                        <h2>Medications Available</h2>
                        <p>0</p>
                    </div>
                    <div class="metric" id="prescriptions-count">
                        <h2>Prescriptions</h2>
                        <p>0</p>
                    </div>
                    <div class="metric" id="pending-prescriptions-count">
                        <h2>Pending Prescriptions</h2>
                        <p>0</p>
                    </div>
                </div>
                <!-- Chart Section -->
            <div class="chart-container">
                <canvas id="medicationChart"></canvas>
            </div>

            </div>
    
            <div id="medication-list" class="content-section">
                <h1>Medication List</h1>
                <section>
                    <form id="medication-form"  >
                        <h2>Add Medication</h2>
                        <div class="input-group-book">
                            <label for="medication-name">Medication Name</label>
                            <input type="text" id="medication-name" name="medicationName" required>
                        </div>
                        <div class="input-group-book">
                            <label for="quantity">Quantity</label>
                            <input type="number" id="quantity" name="quantity" required>
                        </div>
                        <button type="submit">Add Medication</button>
                    </form>
                    <h2>Current Medication List</h2>
                    <ul id="medicationList"></ul>
                </section>
            </div>
    
            <div id="medication-availability" class="content-section">
                <h1>Check Medication Availability</h1>
                <section>
                    <form id="availability-form">
                        <div class="input-group-book">
                            <label for="check-medication-name">Medication Name</label>
                            <input type="text" id="check-medication-name" name="checkMedicationName" required>
                        </div>
                        <button type="submit">Check Availability</button>
                    </form>
                    <div id="availability-result"></div>
                </section>
            </div>
    
            <div id="provide-medication" class="content-section">

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

                <h1>Provide Medication</h1>
                <section>
                    <form id="provide-form">
                        <div class="input-group-book">
                            <label for="provide-medication-name">Medication Name</label>
                            <input type="text" id="provide-medication-name" name="provideMedicationName" required>
                        </div>
                        <div class="input-group-book">
                            <label for="quantity-provide">Quantity</label>
                            <input type="number" id="quantity-provide" name="quantityProvide" required>
                        </div>
                        <button type="submit">Provide Medication</button>
                    </form>
                    <div id="provide-result"></div>
                </section>
            </div>
    
            <div id="settings" class="content-section">
                <h1>Settings</h1>
                <p>Adjust your preferences here.</p>
            </div>
        </div>
    </section>
<footer>
    <p>&copy; 2024 MediVault. All rights reserved.</p>
</footer>

<script>
      // Medication list
      let medicationList = [];

// Event listeners for navigation
const navLinks = document.querySelectorAll('.side-bar nav a');
const contentSections = document.querySelectorAll('.content-section');

navLinks.forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault();

        navLinks.forEach(link => link.classList.remove('active'));
        this.classList.add('active');

        const contentId = this.getAttribute('data-content');
        contentSections.forEach(section => {
            section.classList.remove('active');
            if (section.id === contentId) {
                section.classList.add('active');
            }
        });
    });
});

// Function to update the medication list UI
function updateMedicationList() {
    const medicationListElement = document.getElementById('medicationList');
    medicationListElement.innerHTML = '';

    medicationList.forEach(med => {
        const li = document.createElement('li');
        li.textContent = `${med.name} (Quantity: ${med.quantity})`;
        medicationListElement.appendChild(li);
    });

    // Update medication count
    document.getElementById('medication-count').querySelector('p').textContent = medicationList.length;
}

// Event listener for adding medication
document.getElementById('medication-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('medication-name').value;
    const quantity = parseInt(document.getElementById('quantity').value);

    medicationList.push({ name, quantity });
    updateMedicationList();
    this.reset();
});

// Event listener for checking medication availability
document.getElementById('availability-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const checkName = document.getElementById('check-medication-name').value;
    const resultElement = document.getElementById('availability-result');

    const medication = medicationList.find(med => med.name.toLowerCase() === checkName.toLowerCase());
    if (medication) {
        resultElement.textContent = `${medication.name} is available with quantity ${medication.quantity}.`;
    } else {
        resultElement.textContent = `${checkName} is not available.`;
    }
});

// Event listener for providing medication
document.getElementById('provide-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const provideName = document.getElementById('provide-medication-name').value;
    const provideQuantity = parseInt(document.getElementById('quantity-provide').value);
    const resultElement = document.getElementById('provide-result');

    const medication = medicationList.find(med => med.name.toLowerCase() === provideName.toLowerCase());
    if (medication) {
        if (medication.quantity >= provideQuantity) {
            medication.quantity -= provideQuantity;
            updateMedicationList();
            resultElement.textContent = `${provideQuantity} units of ${provideName} have been provided.`;
        } else {
            resultElement.textContent = `Not enough quantity available for ${provideName}.`;
        }
    } else {
        resultElement.textContent = `${provideName} is not available.`;
    }
});
///////////////////////////////////////////////////////////////////chart//////////////////////////////////////////////////
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.side-bar nav a');
    const contentSections = document.querySelectorAll('.content-section');
    const medicationCountElement = document.getElementById('medication-count').querySelector('p');
    const prescriptionsCountElement = document.getElementById('prescriptions-count').querySelector('p');
    const pendingPrescriptionsCountElement = document.getElementById('pending-prescriptions-count').querySelector('p');

    let medications = 0; // Initial medication count
    let prescriptions = 0; // Initial prescriptions count
    let pendingPrescriptions = 0; // Initial pending prescriptions count

    navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all links
                navLinks.forEach(nav => nav.classList.remove('active'));

                // Hide all content sections
                contentSections.forEach(section => section.classList.remove('active'));

                // Add active class to the clicked link
                this.classList.add('active');

                // Show the corresponding content section
                const contentId = this.getAttribute('data-content');
                document.getElementById(contentId).classList.add('active');
            });
        });


    // Function to update the chart dynamically
    function updateChart(chart, data) {
        chart.data.datasets[0].data = data;
        chart.update();
    }

    // Set up Chart.js chart
    const ctx = document.getElementById('medicationChart').getContext('2d');
    const medicationChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Medications Available', 'Prescriptions', 'Pending Prescriptions'],
            datasets: [{
                label: 'Pharmacy Statistics',
                data: [medications, prescriptions, pendingPrescriptions],
                backgroundColor: ['#007bff', '#28a745', '#ffc107'],
                borderColor: ['#0056b3', '#1e7e34', '#d39e00'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            maintainAspectRatio: false, // Allows for better resizing
        }
    });

    // Sample functions to add data
    function addMedication() {
        medications++;
        medicationCountElement.textContent = medications;
        updateChart(medicationChart, [medications, prescriptions, pendingPrescriptions]);
    }

    function addPrescription() {
        prescriptions++;
        prescriptionsCountElement.textContent = prescriptions;
        updateChart(medicationChart, [medications, prescriptions, pendingPrescriptions]);
    }

    function addPendingPrescription() {
        pendingPrescriptions++;
        pendingPrescriptionsCountElement.textContent = pendingPrescriptions;
        updateChart(medicationChart, [medications, prescriptions, pendingPrescriptions]);
    }

    // Simulate adding medications, prescriptions, and pending prescriptions
    setTimeout(addMedication, 1000); // Add medication after 1 second
    setTimeout(addPrescription, 2000); // Add prescription after 2 seconds
    setTimeout(addPendingPrescription, 3000); // Add pending prescription after 3 seconds
});
/////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////search /////////////////////////////////////////////////////////////
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>
</body>
</html>