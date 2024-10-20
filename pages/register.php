<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include '../includes/SoloHeader.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Ajout de votre fichier CSS principal -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../img/wallpapergrey.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .register-form h1 {
            margin-bottom: 20px;
            font-size: 1.8em;
            color: #333;
        }

        .register-form label {
            font-size: 1em;
            margin: 10px 0 5px;
            display: block;
            color: #555;
        }

        .register-form input[type="text"],
        .register-form input[type="email"],
        .register-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        .register-form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .register-form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="register-container">
    <form class="register-form" method="POST" action="register_handler.php">
        <h1>Inscription</h1>

        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" placeholder="Entrez votre nom d'utilisateur" required>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" placeholder="Entrez votre email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required>

        <input type="submit" value="S'inscrire">
    </form>
</div>
</body>
</html>
