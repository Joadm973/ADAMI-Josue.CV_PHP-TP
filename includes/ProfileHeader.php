<?php
session_start();
?>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<header>
    <nav>
        <ul>
            <div class="left">
                <li><a href="../pages/cv.php">Mon CV</a></li>
                <li><a href="../pages/projets.php">Mes Projets</a></li>
            </div>
            <div class="center">
                <li><a href="../php/index.php"><i class="fas fa-home"></i></a></li>
            </div>
            <div class="right">
                <li><a href="../pages/contact.php">Contact</a></li>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="../pages/login.php">Se connecter</a></li>
                <?php else: ?>
                    <li><a href="../pages/profile.php">Mon Profil</a></li>
                <?php endif; ?>
            </div>
        </ul>
    </nav>
</header>
