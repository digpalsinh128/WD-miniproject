<?php
// Load events dynamically from events.json
$eventsFile = "events.json";
$events = [];

if (file_exists($eventsFile)) {
    $jsonContent = file_get_contents($eventsFile);
    $events = json_decode($jsonContent, true) ?? [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Event Registration Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <header class="header">
        <h1>🎓 College Event Portal</h1>
        <p>Register for upcoming campus events easily</p>
    </header>

    <!-- Navigation Menu -->
    <nav class="navbar">
        <a href="index.php" class="active">Home</a>
        <a href="register.php">Register Now</a>
        <a href="view_registrations.php">View Registrations</a>
        <a href="admin.php">Admin Panel</a>
    </nav>

    <!-- Main Content Container -->
    <main class="container">
        
        <h2>Upcoming College Events</h2>
        <p class="subtitle">Choose an event and fill out the simple registration form.</p>

        <!-- Events Grid -->
        <div class="events-grid">
            
            <?php if (empty($events)): ?>
                <p class="no-data">No active events available at the moment.</p>
            <?php else: ?>
                <?php foreach ($events as $ev): ?>
                    <?php 
                        // Set CSS badge class based on category
                        $cat = strtolower($ev['category']);
                        $badgeClass = 'tech';
                        if ($cat == 'workshop') $badgeClass = 'workshop';
                        if ($cat == 'cultural') $badgeClass = 'cultural';
                        if ($cat == 'sports') $badgeClass = 'sports';
                    ?>
                    <div class="event-card">
                        <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($ev['category']) ?></span>
                        <h3><?= htmlspecialchars($ev['title']) ?></h3>
                        <p><strong>Date:</strong> <?= htmlspecialchars($ev['date']) ?></p>
                        <p><strong>Venue:</strong> <?= htmlspecialchars($ev['venue']) ?></p>
                        <p><?= htmlspecialchars($ev['description']) ?></p>
                        <a href="register.php?event=<?= urlencode($ev['title']) ?>" class="btn">Register</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2026 College Event Portal | Built with HTML, CSS, JS & PHP</p>
    </footer>

</body>
</html>
