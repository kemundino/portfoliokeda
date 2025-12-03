<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | ' : ''; ?>Kedir Mundino | Web Developer & Designer</title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Professional portfolio of Kedir Mundino - Web Developer, Web Designer, and Software Engineer'; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <?php if (isset($additional_styles)): ?>
        <style><?php echo $additional_styles; ?></style>
    <?php endif; ?>
</head>
<body class="dark-theme">
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="logo">
                <a href="index.html">KM</a>
            </div>
            <ul class="nav-links">
                <li><a href="index.html" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.html') ? 'class="active"' : ''; ?>>Home</a></li>
                <li><a href="about.html" <?php echo (basename($_SERVER['PHP_SELF']) == 'about.html') ? 'class="active"' : ''; ?>>About</a></li>
                <li><a href="portfolio.html" <?php echo (basename($_SERVER['PHP_SELF']) == 'portfolio.html') ? 'class="active"' : ''; ?>>Portfolio</a></li>
                <li><a href="services.html" <?php echo (basename($_SERVER['PHP_SELF']) == 'services.html') ? 'class="active"' : ''; ?>>Services</a></li>
                <li><a href="contact.html" <?php echo (basename($_SERVER['PHP_SELF']) == 'contact.html') ? 'class="active"' : ''; ?>>Contact</a></li>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>
