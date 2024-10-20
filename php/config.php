<?php
// Configuration de la base de données
$host = '127.0.0.1';
$db   = 'cv_database';
$user = 'root'; // Mettez le bon nom d'utilisateur
$pass = ''; // Laissez vide si vous n'avez pas de mot de passe pour votre serveur local
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
