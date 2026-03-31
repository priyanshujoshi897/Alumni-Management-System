<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - UGIP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #F8FAFC;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            height: 100vh;
            width: 240px;
            background: #0F172A;
            padding-top: 30px;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar .logo img {
            width: 60px;
        }

        .sidebar .logo h5 {
            color: white;
            margin-top: 10px;
            font-weight: 600;
        }

        .sidebar a {
            position: relative;
            display: block;
            padding: 12px 25px;
            color: #CBD5E1;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .sidebar a:hover {
            transform: translateX(6px);
            color: white;
        }

        .sidebar a::after {
            content: "";
            position: absolute;
            left: 25px;
            bottom: 8px;
            width: 0%;
            height: 2px;
            background: #6366F1;
            transition: 0.3s ease;
        }

        .sidebar a:hover::after {
            width: 60%;
        }

        .sidebar a.active {
            color: white;
        }

        .sidebar a.active::after {
            width: 60%;
        }

        /* Content */
        .content {
            margin-left: 240px;
            padding: 40px;
        }

        .topbar {
            background: white;
            padding: 18px 25px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .card-box {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>

<div class="sidebar">
    <div class="logo">
        <img src="../assets/logo.png.webp">
        <h5>UGIP Admin</h5>
    </div>

    <a href="dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
    <a href="manage_alumni.php" class="<?= $currentPage == 'manage_alumni.php' ? 'active' : '' ?>">Manage Alumni</a>
    <a href="manage_events.php" class="<?= $currentPage == 'manage_events.php' ? 'active' : '' ?>">Manage Events</a>
    <a href="manage_gallery.php" class="<?= $currentPage == 'manage_gallery.php' ? 'active' : '' ?>">Manage Gallery</a>
    <a href="manage_forum.php" class="<?= $currentPage == 'manage_forum.php' ? 'active' : '' ?>">Manage Forum</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="content">
    <div class="topbar d-flex justify-content-between">
        <h5 class="mb-0">Welcome, <?= $_SESSION['name']; ?></h5>
        <span class="text-muted">Admin Panel</span>
    </div>
