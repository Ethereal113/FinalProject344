<?php require_once __DIR__ . '/../config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Line Realty Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style ="
    background-color: #000000; 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #ffffff;
    margin: 20px;
    line-height: 1.5;">
<header>
    <h1>Grand Line Realty Portal</h1>
    <img src="assets/jollyroger.png" alt="Jolly Roger (Logo)" width ="420" height ="320">
    <nav>
        <a href="index.php">Home</a>
        <a href="properties.php">Properties</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
    <hr>
</header>
<main>