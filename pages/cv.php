<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: NeedLogin.php");
    exit;
}

// If the user is logged in, display the content
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon CV</title>
</head>
<body>
<h1>Bienvenue sur votre CV</h1>
<!-- Content for logged-in users -->
</body>
</html>
