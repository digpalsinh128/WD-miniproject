<?php
// PHP Backend Logic - Processing the Form Submission
$message = "";
$messageType = "";

// Check if selected event was passed via URL GET parameter
$selectedEvent = $_GET['event'] ?? '';

// Load events from events.json for dropdown
$eventsFile = "events.json";
$eventsList = [];
if (file_exists($eventsFile)) {
    $eventsList = json_decode(file_get_contents($eventsFile), true) ?? [];
}

// Check if form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Get values from form inputs
    $name = trim($_POST['student_name'] ?? '');
    $roll = trim($_POST['roll_no'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dept = trim($_POST['department'] ?? '');
    $event = trim($_POST['event_name'] ?? '');

    // 2. Simple PHP validation
    if (!empty($name) && !empty($roll) && !empty($email) && !empty($dept) && !empty($event)) {
        
        // Prepare new registration data array
        $newRecord = [
            "name" => $name,
            "roll" => $roll,
            "email" => $email,
            "dept" => $dept,
            "event" => $event,
            "date" => date("Y-m-d H:i:s")
        ];

        // Read existing records from data.json file
        $dataFile = "data.json";
        $existingData = [];

        if (file_exists($dataFile)) {
            $jsonContent = file_get_contents($dataFile);
            $existingData = json_decode($jsonContent, true) ?? [];
        }

        // Add new record to array
        $existingData[] = $newRecord;

        // Save updated array back into data.json
        file_put_contents($dataFile, json_encode($existingData, JSON_PRETTY_PRINT));

        // Set success message
        $message = "Registration successful for " . htmlspecialchars($name) . "!";
        $messageType = "success";

    } else {
        $message = "Please fill in all required fields.";
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <header class="header">
        <h1>🎓 College Event Portal</h1>
        <p>Student Event Registration Form</p>
    </header>

    <!-- Navigation Menu -->
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="register.php" class="active">Register Now</a>
        <a href="view_registrations.php">View Registrations</a>
        <a href="admin.php">Admin Panel</a>
    </nav>

    <!-- Main Content Container -->
    <main class="container">
        
        <div class="form-card">
            <h2>Registration Form</h2>
            <p class="subtitle">Enter your details to confirm your seat.</p>

            <!-- PHP Success/Error Message Display -->
            <?php if (!empty($message)): ?>
                <div class="alert <?= $messageType ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <!-- HTML Form submitting to register.php using POST method -->
            <form action="register.php" method="POST" id="regForm" onsubmit="return validateForm()">
                
                <div class="form-group">
                    <label for="student_name">Full Name:</label>
                    <input type="text" id="student_name" name="student_name" placeholder="e.g. Rahul Sharma" required>
                </div>

                <div class="form-group">
                    <label for="roll_no">Roll Number / Enrollment ID:</label>
                    <input type="text" id="roll_no" name="roll_no" placeholder="e.g. 21CS101" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" placeholder="e.g. rahul@gmail.com" required>
                </div>

                <div class="form-group">
                    <label for="department">Department:</label>
                    <select id="department" name="department" required>
                        <option value="">-- Select Department --</option>
                        <option value="Computer Science (CSE)">Computer Science (CSE)</option>
                        <option value="Information Tech (IT)">Information Tech (IT)</option>
                        <option value="Electronics (ECE)">Electronics (ECE)</option>
                        <option value="Mechanical (ME)">Mechanical (ME)</option>
                        <option value="Civil Engineering">Civil Engineering</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="event_name">Select Event:</label>
                    <select id="event_name" name="event_name" required>
                        <option value="">-- Select an Event --</option>
                        <?php foreach ($eventsList as $ev): ?>
                            <option value="<?= htmlspecialchars($ev['title']) ?>" <?= $selectedEvent == $ev['title'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($ev['title']) ?> (<?= htmlspecialchars($ev['category']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-submit">Submit Registration</button>
            </form>
        </div>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2026 College Event Portal | Built with HTML, CSS, JS & PHP</p>
    </footer>

    <!-- JavaScript File for Simple Form Validation -->
    <script src="script.js"></script>
</body>
</html>
