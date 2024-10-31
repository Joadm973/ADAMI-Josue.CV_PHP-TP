<?php
// Inclure les fichiers nécessaires pour PHPMailer via Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Inclusion automatique avec Composer
include '../includes/ProfileHeader.php'; // Inclusion du header

// Démarrer la session uniquement si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit();
}

// Initialiser la variable de message de succès
$successMessage = "";

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les informations du formulaire
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Créer une instance de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Utilisez le serveur SMTP (Gmail ici)
        $mail->SMTPAuth = true;
        $mail->Username = 'test.319731@gmail.com'; // Votre adresse email Gmail
        $mail->Password = 'tthe jkhd ytum cmes'; // Mot de passe ou mot de passe d'application (si 2FA activé)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataire et expéditeur
        $mail->setFrom('test.319731@gmail.com', 'Formulaire de Contact'); // Adresse expéditeur
        $mail->addAddress($email); // Utilise l'adresse email entrée dans le formulaire

        // Contenu de l'email
        $mail->isHTML(true); // Email au format HTML
        $mail->Subject = 'Nouveau message de contact';
        $mail->Body    = "Nom: $name <br>Email: $email <br>Message: $message";
        $mail->AltBody = "Nom: $name \nEmail: $email \nMessage: $message"; // Version texte si HTML désactivé

        // Envoyer l'email
        $mail->send();
        $successMessage = 'Votre message a été envoyé avec succès.'; // Définir le message de succès
    } catch (Exception $e) {
        $successMessage = "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
    }
}
?>

<!-- HTML du formulaire de contact -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="../css/contact.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1 style="color: white; margin-top: 100px; text-align: center;">Formulaire de Contact</h1>

<form action="contact.php" method="post">
    <label for="name">Nom :</label>
    <input type="text" name="name" required><br>

    <label for="email">Email :</label>
    <input type="email" name="email" required><br>

    <label for="message">Message :</label>
    <textarea name="message" required></textarea><br>

    <button type="submit">Envoyer</button>
</form>

<!-- Afficher le message de succès en bas de la page -->
<?php if ($successMessage): ?>
    <p style="text-align: center; margin-top: 50px; color: green;"><?= $successMessage ?></p>
<?php endif; ?>

</body>
</html>
