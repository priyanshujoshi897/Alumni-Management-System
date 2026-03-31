<?php
if (!isset($_SESSION)) {
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Alumni Panel - UGIP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">

    <style>
        body {
            background: #f8fafc;
            font-family: 'Poppins', sans-serif;
        }
.sidebar {
    height: 100vh;
    background: #0f172a;
    position: fixed;
    width: 240px;
    padding-top: 30px;
    font-family: 'Poppins', sans-serif;
}

.sidebar h5 {
    color: white;
    text-align: center;
    margin-bottom: 30px;
    font-weight: 600;
}

.sidebar a {
    position: relative;
    display: block;
    padding: 12px 25px;
    color: #cbd5e1;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

        /* Slide effect */
        .sidebar a:hover {
            transform: translateX(6px);
            color: #ffffff;
        }

        /* Underline animation */
        .sidebar a::after {
            content: "";
            position: absolute;
            left: 25px;
            bottom: 8px;
            width: 0%;
            height: 2px;
            background: #3B82F6;
            transition: width 0.3s ease;
        }

        /* Hover underline */
        .sidebar a:hover::after {
            width: 60%;
        }

        /* Active link */
        .sidebar a.active {
            color: #ffffff;
        }

        .sidebar a.active::after {
            width: 60%;
        }

        .content {
            margin-left: 240px;
            padding: 40px;
        }

        .card-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h5>Alumni Panel</h5>

    <a href="dashboard.php" class="<?= ($currentPage=='dashboard.php') ? 'active' : '' ?>">Dashboard</a>

    <a href="events.php" class="<?= ($currentPage=='events.php') ? 'active' : '' ?>">Events</a>

    <a href="forum.php" class="<?= ($currentPage=='forum.php') ? 'active' : '' ?>">Discussion Forum</a>

    <a href="post_job.php" class="<?= ($currentPage=='post_job.php') ? 'active' : '' ?>">Post Job</a>

    <a href="jobs.php" class="<?= ($currentPage=='jobs.php') ? 'active' : '' ?>">View Jobs</a>

    <a href="my_jobs.php" class="<?= ($currentPage=='my_jobs.php') ? 'active' : '' ?>">My Posted Jobs</a>
    
    <a href="chat.php" class="<?= ($currentPage=='chat.php') ? 'active' : '' ?>">Chat</a>

    <a href="../logout.php">Logout</a>
</div>

<div class="content">
