<?php
// Inclure les fichiers nécessaires pour PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les informations du formulaire
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Créer une instance de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Utilisez le serveur SMTP de votre choix
        $mail->SMTPAuth = true;
        $mail->Username = 'test319731@gmail.com'; // Votre adresse email
        $mail->Password = 'test.1234'; // Votre mot de passe email ou mot de passe d'application si 2FA activé
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom('votreemail@gmail.com', $name);
        $mail->addAddress('destinataire@example.com'); // Adresse de destination

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'Nouveau message de contact';
        $mail->Body    = "Nom: $name <br>Email: $email <br>Message: $message";
        $mail->AltBody = "Nom: $name \nEmail: $email \nMessage: $message";

        // Envoyer l'email
        $mail->send();
        echo 'Le message a été envoyé avec succès.';
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
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
</head>
<body>
<h1>Formulaire de Contact</h1>
<form action="contact.php" method="post">
    <label for="name">Nom :</label>
    <input type="text" name="name" required><br>

    <label for="email">Email :</label>
    <input type="email" name="email" required><br>

    <label for="message">Message :</label>
    <textarea name="message" required></textarea><br>

    <button type="submit">Envoyer</button>
</form>
</body>
</html>
