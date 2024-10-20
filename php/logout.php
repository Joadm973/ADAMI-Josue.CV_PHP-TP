<?php
session_start();
session_destroy();
header("Location: index.php"); // Redirection après la déconnexion
exit;
?>
