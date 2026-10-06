<?php
// PHP Backend Logic for Admin Dashboard
$dataFile = "data.json";
$eventsFile = "events.json";

// Read registrations
$registrations = file_exists($dataFile) ? (json_decode(file_get_contents($dataFile), true) ?? []) : [];

// Read events
$events = file_exists($eventsFile) ? (json_decode(file_get_contents($eventsFile), true) ?? []) : [];

$msg = "";
$msgType = "success";

// Action 1: Delete a Student Registration
if (isset($_GET['delete_student'])) {
    $index = intval($_GET['delete_student']);
    if (isset($registrations[$index])) {
        $studentName = $registrations[$index]['name'];
        array_splice($registrations, $index, 1); // remove item at index
        file_put_contents($dataFile, json_encode($registrations, JSON_PRETTY_PRINT));
        header("Location: admin.php?msg=Registration+for+" . urlencode($studentName) . "+has+been+deleted.");
        exit;
    }
}

// Action 2: Delete an Event
if (isset($_GET['delete_event'])) {
    $index = intval($_GET['delete_event']);
    if (isset($events[$index])) {
        $eventTitle = $events[$index]['title'];
        array_splice($events, $index, 1); // remove event at index
        file_put_contents($eventsFile, json_encode($events, JSON_PRETTY_PRINT));
        header("Location: admin.php?msg=Event+'" . urlencode($eventTitle) . "'+has+been+deleted.");
        exit;
    }
}

// Action 3: Add a New Event
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $venue = trim($_POST['venue'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!empty($title) && !empty($category) && !empty($date) && !empty($venue) && !empty($description)) {
        $newEvent = [
            "title" => $title,
            "category" => $category,
            "date" => $date,
            "venue" => $venue,
            "description" => $description
        ];
        $events[] = $newEvent;
        file_put_contents($eventsFile, json_encode($events, JSON_PRETTY_PRINT));
        header("Location: admin.php?msg=New+event+'" . urlencode($title) . "'+added+successfully!");
        exit;
    }
}

// Read message from URL GET parameter if redirected
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Campus Event Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <header class="header" style="background: linear-gradient(135deg, #111827, #374151);">
        <h1>🛡️ Admin Control Panel</h1>
        <p>Manage student registrations and campus events</p>
    </header>

    <!-- Navigation Menu -->
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="register.php">Register Now</a>
        <a href="view_registrations.php">View Registrations</a>
        <a href="admin.php" class="active">Admin Panel</a>
    </nav>

    <!-- Main Content Container -->
    <main class="container">

        <!-- Notification Message -->
        <?php if (!empty($msg)): ?>
            <div class="alert success">
                ✅ <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <!-- SECTION 1: MANAGE STUDENT REGISTRATIONS -->
        <section style="margin-bottom: 3rem;">
            <h2>1. Manage Student Registrations</h2>
            <p class="subtitle">Remove or manage students registered for events.</p>

            <div class="table-container">
                <?php if (empty($registrations)): ?>
                    <p class="no-data">No registrations available to display.</p>
                <?php else: ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Roll Number</th>
                                <th>Department</th>
                                <th>Event</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registrations as $index => $row): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>
                                    <td><code><?= htmlspecialchars($row['roll']) ?></code></td>
                                    <td><?= htmlspecialchars($row['dept']) ?></td>
                                    <td><span class="event-tag"><?= htmlspecialchars($row['event']) ?></span></td>
                                    <td>
                                        <a 
                                            href="admin.php?delete_student=<?= $index ?>" 
                                            class="btn-delete"
                                            onclick="return confirm('Are you sure you want to remove this registration?');"
                                        >
                                            🗑️ Remove Student
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </section>

        <!-- SECTION 2: ADD NEW CAMPUS EVENT -->
        <section style="margin-bottom: 3rem;">
            <h2>2. Add New Campus Event</h2>
            <p class="subtitle">Publish a new event to the student portal.</p>

            <div class="form-card" style="max-width: 100%;">
                <form action="admin.php" method="POST">
                    <input type="hidden" name="add_event" value="1">

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem;">
                        <div class="form-group">
                            <label for="title">Event Title:</label>
                            <input type="text" id="title" name="title" placeholder="e.g. AI & Machine Learning Workshop" required>
                        </div>

                        <div class="form-group">
                            <label for="category">Category:</label>
                            <select id="category" name="category" required>
                                <option value="Technical">Technical</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Cultural">Cultural</option>
                                <option value="Sports">Sports</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date">Event Date:</label>
                            <input type="text" id="date" name="date" placeholder="e.g. 15th November 2026" required>
                        </div>

                        <div class="form-group">
                            <label for="venue">Venue:</label>
                            <input type="text" id="venue" name="venue" placeholder="e.g. Main Auditorium" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Event Description:</label>
                        <textarea id="description" name="description" rows="2" class="form-group-input" style="width:100%; padding:0.65rem; border:1px solid #ccc; border-radius:4px;" placeholder="Brief description of the event..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-submit">➕ Publish Event</button>
                </form>
            </div>
        </section>

        <!-- SECTION 3: MANAGE EXISTING EVENTS -->
        <section>
            <h2>3. Manage Campus Events</h2>
            <p class="subtitle">Delete or review active college events.</p>

            <div class="table-container">
                <?php if (empty($events)): ?>
                    <p class="no-data">No active events found.</p>
                <?php else: ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Venue</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($events as $index => $ev): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><strong><?= htmlspecialchars($ev['title']) ?></strong></td>
                                    <td><?= htmlspecialchars($ev['category']) ?></td>
                                    <td><?= htmlspecialchars($ev['date']) ?></td>
                                    <td><?= htmlspecialchars($ev['venue']) ?></td>
                                    <td>
                                        <a 
                                            href="admin.php?delete_event=<?= $index ?>" 
                                            class="btn-delete"
                                            onclick="return confirm('Are you sure you want to delete this event?');"
                                        >
                                            🗑️ Remove Event
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2026 College Event Portal | Built with HTML, CSS, JS & PHP</p>
    </footer>

</body>
</html>
