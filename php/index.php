<?php
global $pdo;
session_start();
require_once '../php/config.php';

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);

if ($isLoggedIn) {
    $userId = $_SESSION['user_id']; // Récupérer l'ID de l'utilisateur connecté

    // Récupérer les informations personnelles depuis la table users
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $user = $stmt->fetch();

    // Récupérer les expériences professionnelles depuis la table work_experience
    $stmt = $pdo->prepare("SELECT * FROM work_experience WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $workExperience = $stmt->fetchAll();

    // Récupérer l'éducation depuis la table education
    $stmt = $pdo->prepare("SELECT * FROM education WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $education = $stmt->fetch();

    // Récupérer les compétences depuis la table skills
    $stmt = $pdo->prepare("SELECT * FROM skills WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $skills = $stmt->fetchAll();

    // Récupérer les projets depuis la table projects
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $projects = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon CV/Portfolio</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<main>
    <!-- Présentation du site -->
    <section class="hero">
        <h1>Bienvenue sur mon site CV/Portfolio</h1>
        <p class="description-site">
            Ce site web a été conçu pour permettre la gestion de CV/Portfolio à travers plusieurs pages interactives.
            Vous pouvez y créer, modifier et personnaliser votre propre CV, ainsi que visualiser et gérer différents portfolios.
            Ce projet inclut diverses fonctionnalités pour simplifier l'édition et l'organisation des informations professionnelles.
            <br><em>Pour voir toutes vos compétences sur le CV veuillez accéder à la rubrique "Mon CV".</em>
        </p>
    </section>

    <!-- Vérifier si l'utilisateur est connecté -->
    <?php if ($isLoggedIn): ?>
        <section class="profile-section">
            <!-- Informations du profil -->
            <div class="profile-header">
                <h1 class="profile-name"><?php echo htmlspecialchars($user['username']); ?></h1>
                <p class="profile-info">Email: <?php echo htmlspecialchars($user['email']); ?> | Rôle: <?php echo htmlspecialchars($user['role']); ?></p>
            </div>

            <div class="profile-details">
                <h2 class="profile-title">Profil</h2>
                <p class="profile-description"><?php echo htmlspecialchars($user['profile_description']); ?></p>
            </div>

            <!-- Compétences -->
            <div class="profile-section skills">
                <h2 class="profile-title">Skills</h2>
                <?php if ($skills): ?>
                    <ul class="skills-list">
                        <?php foreach ($skills as $skill): ?>
                            <li class="skill-item"><?php echo htmlspecialchars($skill['skill_name']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="no-data">Aucune compétence enregistrée.</p>
                <?php endif; ?>
            </div>

            <!-- Projets -->
            <div class="profile-section projects">
                <h2 class="profile-title">Projects</h2>
                <?php if ($projects): ?>
                    <ul class="projects-list">
                        <?php foreach ($projects as $project): ?>
                            <li class="project-item">
                                <strong><?php echo htmlspecialchars($project['title']); ?>:</strong> <?php echo htmlspecialchars($project['description']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="no-data">Aucun projet enregistré.</p>
                <?php endif; ?>
            </div>

            <div class="profile-logout">
                <a href="../pages/profile.php" class="btn btn-edit-profile">Modifier mon profil</a>
                <a href="logout.php" class="btn btn-logout">Se déconnecter</a>
            </div>
        </section>

    <?php else: ?>
        <section class="hero">
            <h2>Connectez-vous pour profiter de toutes les fonctionnalités</h2>
            <p>Pour accéder à votre CV, gérer vos projets, et personnaliser votre profil, veuillez vous connecter ou créer un compte.</p>
            <div class="button-container">
                <a href="../pages/login.php" class="connexion">Connexion</a>
                <a href="../pages/register.php" class="inscription">Inscription</a>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php include '../includes/footer.php'; ?>

</body>
</html>