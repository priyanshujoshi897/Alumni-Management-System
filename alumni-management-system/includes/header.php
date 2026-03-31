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
    <title>UGIP Alumni Portal</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/alumni-management-system/assets/style.css?v=1">
    <link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">



</head>

<body style="font-family: 'Poppins', sans-serif;">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
<div class="container">

    <!-- Logo + Name -->
    <a class="navbar-brand d-flex align-items-center fw-semibold" href="index.php">
        <img src="/alumni-management-system/assets/logo.png.webp"
             alt="UGIP Logo"
             width="40"
             height="40"
             class="me-2 rounded-circle">
        UGIP Alumni Portal
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">

            <li class="nav-item">
                <a class="nav-link <?php if($currentPage=="index.php") echo "active"; ?>" href="index.php">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if($currentPage=="about.php") echo "active"; ?>" href="about.php">About Us</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if($currentPage=="events.php") echo "active"; ?>" href="events.php">Events</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if($currentPage=="gallery.php") echo "active"; ?>" href="gallery.php">Gallery</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php if($currentPage=="login.php") echo "active"; ?>"
                   href="#" role="button" data-bs-toggle="dropdown">
                    Login
                </a>
                <ul class="dropdown-menu dropdown-menu-dark shadow">
                    <li><a class="dropdown-item" href="login.php?role=admin">Admin Login</a></li>
                    <li><a class="dropdown-item" href="login.php?role=alumni">Alumni Login</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if($currentPage=="register.php") echo "active"; ?>" href="register.php">New Alumni</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php if($currentPage=="contact.php") echo "active"; ?>" href="contact.php">Contact Us</a>
            </li>

        </ul>
    </div>

</div>
</nav>

<div class="container mt-4">
