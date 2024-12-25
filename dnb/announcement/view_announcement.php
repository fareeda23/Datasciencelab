<?php
session_start();
require '../db.php';

try {
    $user_id = $_SESSION['user']['id'];

    // Fetch announcements based on subscriptions
    $query_annc = "
        SELECT a.Announce_ID, a.Title, a.Content, a.Posted_Date
        FROM announcement a
        JOIN subscription s ON a.Category_ID = s.Category_ID
        WHERE s.USN = :user_id";
    $user_details = $pdo->prepare($query_annc);
    $user_details->execute(['user_id' => $user_id]);
    $announcements = $user_details->fetchAll(PDO::FETCH_ASSOC);

    // Fetch announcement types for the modal (This is no longer needed since we're removing the modal)
    $query_annc_type = "SELECT * FROM announcement_type";
    $announcement_t = $pdo->query($query_annc_type);
    $announcements_type = $announcement_t->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container { width: 85%; margin: 50px auto; max-width: 1200px; }
        h1 { text-align: center; font-size: 2.5em; margin-bottom: 20px; color: #333; }
        .announcement-item { background-color: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin: 10px 0; cursor: pointer; }
        .announcement-item:hover { box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); }
        .announcement-title { font-size: 1.8em; font-weight: bold; color: #333; margin-bottom: 10px; }
        .announcement-date { font-size: 14px; color: #777; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../student_dashboard.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#courses"></a></li>
                    <li class="nav-item"><a class="nav-link" href="#profile"></a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Announcements</h1>

        <ul class="announcement-list">
            <?php if (count($announcements) > 0): ?>
                <?php foreach ($announcements as $announcement): ?>
                    <li class="announcement-item" data-id="<?= $announcement['Announce_ID'] ?>" data-title="<?= htmlspecialchars($announcement['Title']) ?>" data-content="<?= htmlspecialchars($announcement['Content']) ?>">
                        <div class="announcement-title"><?= htmlspecialchars($announcement['Title']) ?></div>
                        <div class="announcement-date">Posted on: <?= $announcement['Posted_Date'] ?></div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No announcements available for your subscriptions.</p>
            <?php endif; ?>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>