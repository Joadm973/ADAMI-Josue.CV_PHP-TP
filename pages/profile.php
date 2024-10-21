<?php
session_start();
require '../php/config.php';

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);

// Déconnexion
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];

    // Récupérer les informations de base de l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $user = $stmt->fetch();

    // Récupérer les expériences professionnelles
    $stmt = $pdo->prepare("SELECT * FROM work_experience WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $workExperience = $stmt->fetchAll();

    // Récupérer l'éducation
    $stmt = $pdo->prepare("SELECT * FROM education WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $education = $stmt->fetch();

    // Récupérer les compétences
    $stmt = $pdo->prepare("SELECT * FROM skills WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $skills = $stmt->fetchAll();

    // Récupérer les projets
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $projects = $stmt->fetchAll();

    // Si des informations ont été envoyées via formulaire, les traiter et les enregistrer
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Mise à jour des informations de base (Nom d'utilisateur, Email et Description)
        if (isset($_POST['update_profile'])) {
            $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, profile_description = :profile_description WHERE id = :user_id");
            $stmt->execute([
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'profile_description' => $_POST['profile_description'],
                'user_id' => $userId
            ]);
        }

        // Mise à jour des expériences professionnelles
        if (isset($_POST['position']) && isset($_POST['company']) && isset($_POST['duration'])) {
            for ($i = 0; $i < count($_POST['position']); $i++) {
                // Si l'expérience existe, la mettre à jour, sinon l'insérer
                if (isset($workExperience[$i])) {
                    $stmt = $pdo->prepare("UPDATE work_experience SET position = :position, company = :company, duration = :duration, description = :description WHERE user_id = :user_id AND id = :id");
                    $stmt->execute([
                        'position' => $_POST['position'][$i],
                        'company' => $_POST['company'][$i],
                        'duration' => $_POST['duration'][$i],
                        'description' => $_POST['description'][$i],
                        'user_id' => $userId,
                        'id' => $workExperience[$i]['id']
                    ]);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO work_experience (user_id, position, company, duration, description) VALUES (:user_id, :position, :company, :duration, :description)");
                    $stmt->execute([
                        'user_id' => $userId,
                        'position' => $_POST['position'][$i],
                        'company' => $_POST['company'][$i],
                        'duration' => $_POST['duration'][$i],
                        'description' => $_POST['description'][$i]
                    ]);
                }
            }
        }

        // Mise à jour de l'éducation
        if (isset($_POST['degree']) && isset($_POST['institution']) && isset($_POST['years'])) {
            if ($education) {
                $stmt = $pdo->prepare("UPDATE education SET degree = :degree, institution = :institution, years = :years WHERE user_id = :user_id");
                $stmt->execute([
                    'degree' => $_POST['degree'],
                    'institution' => $_POST['institution'],
                    'years' => $_POST['years'],
                    'user_id' => $userId
                ]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO education (user_id, degree, institution, years) VALUES (:user_id, :degree, :institution, :years)");
                $stmt->execute([
                    'user_id' => $userId,
                    'degree' => $_POST['degree'],
                    'institution' => $_POST['institution'],
                    'years' => $_POST['years']
                ]);
            }
        }

        // Mise à jour des compétences
        if (isset($_POST['skills'])) {
            foreach ($_POST['skills'] as $i => $skill) {
                if (isset($skills[$i])) {
                    $stmt = $pdo->prepare("UPDATE skills SET skill_name = :skill_name WHERE id = :id AND user_id = :user_id");
                    $stmt->execute([
                        'skill_name' => $skill,
                        'id' => $skills[$i]['id'],
                        'user_id' => $userId
                    ]);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO skills (user_id, skill_name) VALUES (:user_id, :skill_name)");
                    $stmt->execute([
                        'user_id' => $userId,
                        'skill_name' => $skill
                    ]);
                }
            }
        }

        // Mise à jour des projets
        if (isset($_POST['project_title']) && isset($_POST['project_description'])) {
            for ($i = 0; $i < count($_POST['project_title']); $i++) {
                if (isset($projects[$i])) {
                    $stmt = $pdo->prepare("UPDATE projects SET title = :title, description = :description WHERE id = :id AND user_id = :user_id");
                    $stmt->execute([
                        'title' => $_POST['project_title'][$i],
                        'description' => $_POST['project_description'][$i],
                        'id' => $projects[$i]['id'],
                        'user_id' => $userId
                    ]);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO projects (user_id, title, description) VALUES (:user_id, :title, :description)");
                    $stmt->execute([
                        'user_id' => $userId,
                        'title' => $_POST['project_title'][$i],
                        'description' => $_POST['project_description'][$i]
                    ]);
                }
            }
        }

        // Redirection après la mise à jour
        header("Location: profile.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];

    // Récupérer les informations de base de l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $user = $stmt->fetch();

    // Vérifier si l'utilisateur a déjà des expériences professionnelles
    $stmt = $pdo->prepare("SELECT * FROM work_experience WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $workExperience = $stmt->fetchAll();

    // Si l'utilisateur n'a pas encore d'expériences professionnelles, on en insère avec des valeurs par défaut
    if (count($workExperience) == 0) {
        $stmt = $pdo->prepare("INSERT INTO work_experience (user_id, position, company, duration, description) 
                               VALUES (:user_id, :position, :company, :duration, :description)");
        $stmt->execute([
            'user_id' => $userId,
            'position' => 'Poste à définir',
            'company' => 'Entreprise à définir',
            'duration' => 'Durée à définir',
            'description' => 'Description à définir'
        ]);

        // Récupérer de nouveau les expériences professionnelles après insertion
        $stmt = $pdo->prepare("SELECT * FROM work_experience WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $workExperience = $stmt->fetchAll();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_defaults'])) {
    $stmt = $pdo->prepare("UPDATE work_experience 
                           SET position = 'Poste à définir', 
                               company = 'Entreprise à définir', 
                               duration = 'Durée à définir', 
                               description = 'Description à définir' 
                           WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);

    // Redirection après la mise à jour
    header("Location: profile.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>

<?php include '../includes/ProfileHeader.php'; ?>

<main>
    <section>
        <h1>Modifier le Profil</h1>
        <form method="POST" action="">
            <!-- Informations personnelles -->
            <h2>Informations personnelles</h2>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="email">Email :</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="profile_description">Description :</label>
            <textarea name="profile_description" rows="4" required><?php echo htmlspecialchars($user['profile_description']); ?></textarea>


            <!-- Expériences professionnelles -->
            <h2>Expériences professionnelles</h2>
            <?php if ($workExperience): ?>
                <?php foreach ($workExperience as $index => $experience): ?>
                    <label for="position_<?php echo $index; ?>">Poste :</label>
                    <input type="text" name="position[]" id="position_<?php echo $index; ?>" value="<?php echo htmlspecialchars($experience['position']); ?>" required>

                    <label for="company_<?php echo $index; ?>">Entreprise :</label>
                    <input type="text" name="company[]" id="company_<?php echo $index; ?>" value="<?php echo htmlspecialchars($experience['company']); ?>" required>

                    <label for="duration_<?php echo $index; ?>">Durée :</label>
                    <input type="text" name="duration[]" id="duration_<?php echo $index; ?>" value="<?php echo htmlspecialchars($experience['duration']); ?>" required>

                    <label for="description_<?php echo $index; ?>">Description :</label>
                    <textarea name="description[]" id="description_<?php echo $index; ?>" rows="3" required><?php echo htmlspecialchars($experience['description']); ?></textarea>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune expérience professionnelle enregistrée.</p>
            <?php endif; ?>

            <!-- Éducation -->
            <h2>Éducation</h2>
            <label for="degree">Diplôme :</label>
            <input type="text" name="degree" value="<?php echo isset($education['degree']) ? htmlspecialchars($education['degree']) : ''; ?>" required>

            <label for="institution">Établissement :</label>
            <input type="text" name="institution" value="<?php echo isset($education['institution']) ? htmlspecialchars($education['institution']) : ''; ?>" required>

            <label for="years">Années :</label>
            <input type="text" name="years" value="<?php echo isset($education['years']) ? htmlspecialchars($education['years']) : ''; ?>" required>

            <!-- Compétences -->
            <h2>Compétences</h2>
            <?php if ($skills): ?>
                <?php foreach ($skills as $index => $skill): ?>
                    <input type="text" name="skills[]" value="<?php echo htmlspecialchars($skill['skill_name']); ?>" required>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune compétence enregistrée.</p>
            <?php endif; ?>

            <!-- Projets -->
            <h2>Projets</h2>
            <?php if ($projects): ?>
                <?php foreach ($projects as $index => $project): ?>
                    <label for="project_title_<?php echo $index; ?>">Titre du projet :</label>
                    <input type="text" name="project_title[]" value="<?php echo htmlspecialchars($project['title']); ?>" required>

                    <label for="project_description_<?php echo $index; ?>">Description du projet :</label>
                    <textarea name="project_description[]" rows="3" required><?php echo htmlspecialchars($project['description']); ?></textarea>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun projet enregistré.</p>
            <?php endif; ?>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <input type="submit" name="update_profile" value="Mettre à jour" style="margin-right: 10px;">
                <!-- Bouton de déconnexion -->
                <input type="submit" name="logout" value="Se déconnecter" style="background-color: red; color: white;">
            </div>


        </form>
    </section>
</main>

</body>
</html>
