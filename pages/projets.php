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

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Projets</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<main class="container">
    <h1>Mes Projets</h1>

    <!-- Liste des projets de l'utilisateur -->
    <section class="projects-list">
        <?php if ($projects): ?>
            <ul>
                <?php foreach ($projects as $project): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p><?php echo htmlspecialchars($project['description']); ?></p>
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
            <div>
                <label for="title">Titre :</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div>
                <label for="description">Description :</label>
                <textarea name="description" id="description" rows="5" required></textarea>
            </div>
            <div>
                <button type="submit" name="add_project">Ajouter le projet</button>
            </div>
        </form>
    </section>
</main>

<?php include '../includes/footer.php'; ?>

</body>
</html>
