<?php
// PHP Backend Logic - Read Registrations from data.json file
$dataFile = "data.json";
$registrations = [];

if (file_exists($dataFile)) {
    $jsonContent = file_get_contents($dataFile);
    $registrations = json_decode($jsonContent, true) ?? [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Registered Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <header class="header">
        <h1>🎓 College Event Portal</h1>
        <p>Registered Students Record</p>
    </header>

    <!-- Navigation Menu -->
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="register.php">Register Now</a>
        <a href="view_registrations.php" class="active">View Registrations</a>
        <a href="admin.php">Admin Panel</a>
    </nav>

    <!-- Main Content Container -->
    <main class="container">
        
        <h2>Student Registrations List</h2>
        <p class="subtitle">Total Registrations Recorded: <strong><?= count($registrations) ?></strong></p>

        <!-- HTML Table Displaying PHP Data -->
        <div class="table-container">
            <?php if (empty($registrations)): ?>
                <p class="no-data">No registrations found yet. Be the first to register!</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Student Name</th>
                            <th>Roll Number</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Event Name</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registrations as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>
                                <td><code><?= htmlspecialchars($row['roll']) ?></code></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['dept']) ?></td>
                                <td><span class="event-tag"><?= htmlspecialchars($row['event']) ?></span></td>
                                <td><?= htmlspecialchars($row['date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2026 College Event Portal | Built with HTML, CSS, JS & PHP</p>
    </footer>

</body>
</html>
