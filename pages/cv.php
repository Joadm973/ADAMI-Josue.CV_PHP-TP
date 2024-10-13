<?php
$cvFile = "../img/CV_ADAMI.pdf";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon CV</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Assurez-vous que le chemin vers style.css est correct -->
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="../php/index.php">Accueil</a></li>
            <li><a href="#">À propos</a></li>
            <li><a href="../pages/contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="container">
        <h1>Mon CV</h1>
        <p>Bonjour ! Voici mon CV.</p>
        <p>Vous pouvez le télécharger en cliquant sur le lien ci-dessous :</p>
        <a href="<?php echo $cvFile; ?>" class="btn-download" target="_blank">Télécharger mon CV (PDF)</a>
    </div>
</main>

<footer>
    <p>&copy; Fait par ADAMI Josué.</p>
</footer>
</body>
</html>
