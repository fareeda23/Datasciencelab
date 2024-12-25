<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['type'] !== 'student') {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-item img {
            object-fit: cover;
            height: 400px;
        }
        .container {
            padding: 30px;
        }
        h1, h2 {
            color: #007bff;
        }
        /* Sidebar Styles */
        #sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }
        #sidebar .nav-link {
            color: white;
        }
        #sidebar .nav-link:hover {
            background-color: #007bff;
        }
        .main-content {
            margin-left: 260px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div id="sidebar">
        <div class="container-fluid">
            <h4 class="text-white text-center mb-4">Student Dashboard</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="student_dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="student_dashboard.php">Dashboard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Container -->
        <div class="container mt-4">
            <h1>Welcome, <?= htmlspecialchars($user['name']) ?></h1>
            <h2>Your Dashboard</h2>

            <!-- Bootstrap Carousel -->
            <div id="studentCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="image1.jpg" class="d-block w-100" alt="Announcement 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Announcement 1</h5>
                            <p>Important announcement regarding exams and schedule.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="image2.webp" class="d-block w-100" alt="Announcement 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Announcement 2</h5>
                            <p>Stay updated on the latest events and campus news.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="image3.png" class="d-block w-100" alt="Announcement 3">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Announcement 3</h5>
                            <p>Check out new resources and opportunities for students.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#studentCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#studentCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!-- Cards Section -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-bg-warning mb-3">
                        <div class="card-header">Notifications</div>
                        <div class="card-body">
                            <h5 class="card-title">Latest Updates</h5>
                            <p class="card-text">Stay informed about important updates and announcements.</p>
                            <a href="announcement/view_announcement.php" class="btn btn-light">View Notifications</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
