<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main>
    <h1>Mon Profil</h1>
    <p>Bonjour, <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?> !</p>
    <p>Rôle: <?php echo $_SESSION['role']; ?></p>

    <a href="../php/logout.php">Se déconnecter</a>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>
