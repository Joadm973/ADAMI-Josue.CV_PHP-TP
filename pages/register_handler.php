<?php
require '../php/config.php'; // Inclure le fichier de configuration pour la base de données

// Vérifier si les données du formulaire sont envoyées via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash du mot de passe pour la sécurité

    // Vérifier si l'email existe déjà dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        // Si l'utilisateur existe déjà, renvoyer un message d'erreur ou rediriger vers une autre page
        echo "Cet email est déjà utilisé.";
    } else {
        // Insérer un nouvel utilisateur dans la base de données
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);

        // Rediriger vers une autre page après l'inscription
        header("Location: login.php");
        exit;
    }
}
?>
