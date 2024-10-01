<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-moi</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Chemin relatif au fichier CSS -->
</head>
<body>
<?php include '../includes/header.php'; ?>

<main>
    <h1>Contactez-moi</h1>
    <form action="../php/contact_form.php" method="POST">
        <label for="name">Nom:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Envoyer</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>
