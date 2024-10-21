<?php
session_start();
require '../php/config.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: NeedLogin.php");
    exit;
}

// Récupérer l'ID de l'utilisateur connecté
$userId = $_SESSION['user_id'];

// Récupérer les projets de l'utilisateur depuis la base de données
$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = :user_id");
$stmt->execute(['user_id' => $userId]);
$projects = $stmt->fetchAll();

// Ajouter un projet
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_project'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);

    // Insertion du nouveau projet dans la base de données
    $stmt = $pdo->prepare("INSERT INTO projects (user_id, title, description) VALUES (:user_id, :title, :description)");
    $stmt->execute(['user_id' => $userId, 'title' => $title, 'description' => $description]);

    header("Location: projets.php");
    exit;
}

// Supprimer un projet
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_project'])) {
    $projectId = $_POST['project_id'];

    // Suppression du projet dans la base de données
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $projectId, 'user_id' => $userId]);

    header("Location: projets.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Projets</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/projets.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<!-- Add margin-top to create space between header and content -->
<main class="container" style="margin-top: 100px;">
    <h1>Mes Projets</h1>

    <!-- Liste des projets de l'utilisateur -->
    <section class="projects-list">
        <?php if ($projects): ?>
            <ul>
                <?php foreach ($projects as $project): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p><?php echo htmlspecialchars($project['description']); ?></p>
                        <!-- Formulaire de suppression -->
                        <form action="projets.php" method="post" style="display:inline;">
                            <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                            <button type="submit" name="delete_project" class="delete-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');">Supprimer</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucun projet enregistré pour le moment.</p>
        <?php endif; ?>
    </section>

    <!-- Formulaire pour ajouter un nouveau projet -->
    <section class="add-project">
        <h2>Ajouter un nouveau projet</h2>
        <form action="projets.php" method="post">
            <div class="form-group">
                <label for="title">Titre :</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea name="description" id="description" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="add_project">Ajouter le projet</button>
            </div>
        </form>
    </section>
</main>

</body>
</html>
