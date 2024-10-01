<?php
// Inclure le fichier de configuration pour la connexion à la base de données
include '../php/config.php';

// Initialiser les variables pour le traitement du formulaire
$name = $email = $message = '';
$errors = [];

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation des données du formulaire
    if (empty($_POST["name"])) {
        $errors['name'] = "Le nom est requis.";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
    }

    if (empty($_POST["email"])) {
        $errors['email'] = "L'email est requis.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
    }

    if (empty($_POST["message"])) {
        $errors['message'] = "Le message est requis.";
    } else {
        $message = htmlspecialchars(trim($_POST["message"]));
    }

    // Si aucune erreur, traiter l'envoi (ex. : envoyer un email, sauvegarder dans la base de données, etc.)
    if (empty($errors)) {
        // Ici, tu pourrais envoyer un email ou stocker le message dans une base de données
        // Pour l'exemple, nous allons juste afficher un message de succès
        echo "<div class='success'>Merci $name, votre message a été envoyé !</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css"> <!-- Inclure le CSS -->
    <title>Contact</title>
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container">
    <h1>Contactez-nous</h1>
    <form action="contact.php" method="post">
        <div>
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
            <span class="error"><?php echo isset($errors['name']) ? $errors['name'] : ''; ?></span>
        </div>
        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <span class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
        </div>
        <div>
            <label for="message">Message :</label>
            <textarea id="message" name="message"><?php echo htmlspecialchars($message); ?></textarea>
            <span class="error"><?php echo isset($errors['message']) ? $errors['message'] : ''; ?></span>
        </div>
        <div>
            <button type="submit">Envoyer</button>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
