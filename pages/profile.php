<?php
session_start();
require '../php/config.php';

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);

// Récupérer les informations de l'utilisateur connecté
if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $user = $stmt->fetch();

    // Simuler des données d'exemple (remplacer par les données réelles si elles existent dans la base de données)
    $workExperience = [
        [
            'position' => 'Poste actuelle',
            'company' => 'Votre Entreprise',
            'duration' => 'Durée',
            'description' => [
                'Description de votre poste.',
            ]
        ]
    ];

    $education = [
        'degree' => 'Votre diplome',
        'institution' => 'Nom ecole',
        'years' => 'XXXX - XXXX'
    ];

    $skills = ['Décrivez vos compétences'];

    $projects = [
        [
            'title' => 'Portfolio Website',
            'description' => 'A personal website showcasing my work and skills.'
        ]
    ];

    // Si des informations ont été envoyées via formulaire, les traiter et les enregistrer
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update_profile'])) {
            // Mise à jour des informations de base (Nom d'utilisateur, Email et Description)
            $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, profile_description = :profile_description WHERE id = :user_id");
            $stmt->execute([
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'profile_description' => $_POST['profile_description'],
                'user_id' => $userId
            ]);
        }

        // Vous pouvez également gérer les autres sections ici comme expérience, compétences, etc.
        header("Location: profile.php");
        exit;
    }
} else {
    // Si l'utilisateur n'est pas connecté, afficher un profil vierge et désactiver l'édition
    $user = [
        'username' => 'Invité',
        'email' => '',
        'profile_description' => 'Vous devez être connecté pour modifier votre profil.'
    ];
    $isEditable = false; // Désactiver les champs modifiables
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main style="padding-bottom: 50px;">
    <section>
        <h1>Profil</h1>
        <form method="POST" action="">
            <h2>Informations personnelles</h2>

            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" <?php echo !$isLoggedIn ? 'disabled' : ''; ?> required>

            <label for="email">Email :</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" <?php echo !$isLoggedIn ? 'disabled' : ''; ?> required>

            <label for="profile_description">Description du profil :</label>
            <textarea name="profile_description" rows="4" cols="50" <?php echo !$isLoggedIn ? 'disabled' : ''; ?>><?php echo htmlspecialchars($user['profile_description']); ?></textarea>

            <?php if ($isLoggedIn): ?>
                <input type="submit" name="update_profile" value="Mettre à jour le profil">
            <?php endif; ?>

            <h2>Expériences professionnelles</h2>
            <!-- Ajoutez la section pour les expériences professionnelles ici si besoin -->

            <h2>Éducation</h2>
            <!-- Ajoutez la section pour l'éducation ici si besoin -->

            <h2>Compétences</h2>
            <!-- Ajoutez la section pour les compétences ici si besoin -->

            <h2>Projets</h2>
            <!-- Ajoutez la section pour les projets ici si besoin -->
        </form>
    </section>
</main>
</body>
</html>
