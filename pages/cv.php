<?php
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
    <title>Mon CV</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<main>
    <?php if ($isLoggedIn): ?>
        <section class="profile-section">
            <!-- Section Profil -->
            <div class="profile-header">
                <h1 class="profile-name"><?php echo htmlspecialchars($user['username']); ?></h1>
                <p class="profile-info">Email: <?php echo htmlspecialchars($user['email']); ?> | Rôle: <?php echo htmlspecialchars($user['role']); ?></p>
            </div>
            <div class="profile-details">
                <h2 class="profile-title">Profil</h2>
                <p class="profile-description"><?php echo htmlspecialchars($user['profile_description']) ?: "Aucune description disponible."; ?></p>
            </div>

            <!-- Section Work Experience -->
            <div class="profile-section work-experience">
                <h2 class="profile-title">Work Experience</h2>
                <?php if ($workExperience): ?>
                    <ul class="experience-list">
                        <?php foreach ($workExperience as $experience): ?>
                            <li class="experience-item">
                                <strong><?php echo htmlspecialchars($experience['position']); ?>, <?php echo htmlspecialchars($experience['company']); ?></strong><br>
                                <span class="experience-duration"><?php echo htmlspecialchars($experience['duration']); ?></span>
                                <ul class="experience-description">
                                    <li><?php echo htmlspecialchars($experience['description']); ?></li>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="no-data">Aucune expérience professionnelle enregistrée.</p>
                <?php endif; ?>
            </div>

            <!-- Section Education -->
            <div class="profile-section education">
                <h2 class="profile-title">Education</h2>
                <?php if ($education): ?>
                    <p><?php echo htmlspecialchars($education['degree']); ?>, <?php echo htmlspecialchars($education['institution']); ?> (<?php echo htmlspecialchars($education['years']); ?>)</p>
                <?php else: ?>
                    <p class="no-data">Aucune information d'éducation enregistrée.</p>
                <?php endif; ?>
            </div>

            <!-- Section Skills -->
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

            <!-- Section Projects -->
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
                <a href="../php/logout.php" class="btn btn-logout">Se déconnecter</a>
            </div>
        </section>
    <?php else: ?>
        <section class="hero">
            <h2>Connectez-vous pour accéder à votre CV</h2>
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