<?php 
// dashboard.php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../config.php';

// Quick stats
$stats = [];

// Subscribers
$res = $conn->query("SELECT COUNT(*) AS total,
    SUM(CASE WHEN status=1 THEN 1 ELSE 0 END) AS active 
    FROM subscribers");
$stats['subscribers'] = $res->fetch_assoc();

// Posts
$res = $conn->query("SELECT COUNT(*) AS total FROM posts");
$stats['posts'] = $res->fetch_assoc();

// Components
$res = $conn->query("SELECT COUNT(*) AS total FROM component_master");
$stats['components'] = $res->fetch_assoc();

// Newsletters
$res = $conn->query("SELECT COUNT(*) AS total FROM newsletter_master");
$stats['newsletters'] = $res->fetch_assoc();

// Last 5 Posts
$latest_posts = $conn->query("SELECT id, title, post_date FROM posts ORDER BY post_date DESC LIMIT 5");

// Last 5 Newsletters
$latest_newsletters = $conn->query("SELECT id, title, created_at FROM newsletter_master ORDER BY created_at DESC LIMIT 5");

// Toastify flag
$show_welcome = false;
if (!empty($_SESSION['show_welcome'])) {
    $show_welcome = true;
    unset($_SESSION['show_welcome']); 
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        body { background: #f5f7fb; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            background: #212529;
            padding-top: 70px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.2);
        }
        .sidebar a {
            color: #adb5bd;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .sidebar a:hover {
            background: #343a40;
            color: #fff;
            padding-left: 25px;
        }
        .sidebar a.active {
            background: #f5945c;
            color: #fff;
            font-weight: bold;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .card { border-radius: 16px; }
        .stat-card { transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body>
<?php include '../inc/header.php'; ?> 

<!-- Sidebar -->
<div class="sidebar">
    <a href="dashboard.php" class="active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
    <a href="posts.php"><i class="bi bi-file-earmark-text me-2"></i> Posts</a>
    <a href="component_add.php"><i class="bi bi-plus-square me-2"></i> Add Component</a>
    <a href="component_edit.php"><i class="bi bi-pencil-square me-2"></i> Edit Component</a>
    <a href="component_delete.php"><i class="bi bi-trash me-2"></i> Delete Component</a>
    <a href="components.php"><i class="bi bi-box me-2"></i> All Components</a>
</div>

<!-- Main Content -->
<div class="content">
    <h1 class="mb-4">📊 Admin Dashboard</h1>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-bg-primary shadow-sm stat-card">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill fs-1"></i>
                    <h5>Total Subscribers</h5>
                    <h2><?= $stats['subscribers']['total'] ?? 0 ?></h2>
                    <small>Active: <?= $stats['subscribers']['active'] ?? 0 ?></small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-success shadow-sm stat-card">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-text-fill fs-1"></i>
                    <h5>Total Posts</h5>
                    <h2><?= $stats['posts']['total'] ?? 0 ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-warning shadow-sm stat-card">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam-fill fs-1"></i>
                    <h5>Total Components</h5>
                    <h2><?= $stats['components']['total'] ?? 0 ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-info shadow-sm stat-card">
                <div class="card-body text-center">
                    <i class="bi bi-envelope-paper-fill fs-1"></i>
                    <h5>Total Newsletters</h5>
                    <h2><?= $stats['newsletters']['total'] ?? 0 ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest posts & newsletters -->
    <div class="row mt-5">
        <div class="col-md-6">
            <h4>📝 Latest Posts</h4>
            <ul class="list-group shadow-sm">
                <?php while($row = $latest_posts->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="post_edit.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></a>
                        <span class="badge bg-secondary"><?= $row['post_date'] ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="col-md-6">
            <h4>📧 Latest Newsletters</h4>
            <ul class="list-group shadow-sm">
                <?php while($row = $latest_newsletters->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="newsletter_master.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></a>
                        <span class="badge bg-secondary"><?= $row['created_at'] ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
<?php if ($show_welcome): ?>
Toastify({
  text: "👋 Welcome back, <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?>!",
  duration: 3000,
  gravity: "top",
  position: "right",
  backgroundColor: "#2a9d8f",
  close: true
}).showToast();
<?php endif; ?>
</script>
</body>
</html>
