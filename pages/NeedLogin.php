<?php
global $pdo;
session_start();
require '../php/config.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifie si l'utilisateur existe dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Authentification réussie, démarrer la session
        $_SESSION['user_id'] = $user['id'];
        header("Location: profile.php");
        exit;
    } else {
        // Afficher un message d'erreur si l'utilisateur n'existe pas ou si le mot de passe est incorrect
        $errors['password'] = "Email ou mot de passe incorrect.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<link rel="stylesheet" href="../css/login.css">
<?php include '../includes/header.php'; ?>

<div class="container">
    <h1>Connectez-vous afin d'accéder à cette fonctionnalité 😉</h1>
    <form action="login.php" method="post">
        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            <span class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
        </div>
        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            <span class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
        </div>
        <div>
            <button type="submit">Se connecter</button>
        </div>
    </form>
    <p>Pas encore inscrit ? <a href="register.php">Créez un compte</a></p>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
