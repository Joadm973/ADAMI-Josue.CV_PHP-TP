<?php
session_start();
session_unset(); // Supprimer toutes les variables de session
session_destroy(); // Détruire la session en cours

// Rediriger vers la page de connexion
header("Location: login.php");
exit;
?>
