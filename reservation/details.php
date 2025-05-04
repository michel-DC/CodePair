<?php
session_start();
$link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");

if (!isset($_SESSION['connecté']) || $_SESSION['connecté'] !== true || $_SESSION['role'] !== 'user') {
    header("Location: login.php?erreur=non_connecte");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Aucune réservation spécifiée.";
    exit();
}

$reservation_id = intval($_GET['id']);

// Requête pour récupérer les détails de la réservation
$query = "
    SELECT r.*, d.fullname AS dev_nom, d.photo_profil, d.stack, d.description
    FROM reservations r
    JOIN developpeurs d ON r.dev_id = d.id
    WHERE r.id = $reservation_id AND r.user_id = {$_SESSION['user_id']}
";

$result = mysqli_query($link, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Réservation non trouvée ou vous n'y avez pas accès.";
    exit();
}

$reservation = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la réservation</title>
    <link rel="shortcut icon" href="../assets/images/icon/codepair_icon.PNG" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap');
        body {
            font-family: "Space Grotesk", sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 20px;
            padding: 20px;
        }

        .container h1 {
            font-size: 36px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 45px;
            color: #151717;
        }

        .container h1 span {
            color: #2ECC71;
            position: relative;
        }

        .container h1 span::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #2ECC71;
            border-radius: 3px;
        }

        .info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .info h2 {
            color: #2ECC71;
            margin-bottom: 20px;
        }

        .info p {
            margin: 10px 0;
            color: #666;
        }

        .info img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .thank-you {
            text-align: center;
            margin-top: 30px;
            font-style: italic;
            color: #666;
        }

        .home-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #2ECC71;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .home-button:hover {
            background-color: rgb(145, 231, 181);
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Résumé de votre <span>réservation</span></h1>

    <div class="info">
        <h2>Développeur réservé :</h2>
        <p><strong>Nom :</strong> <?= htmlspecialchars($reservation['dev_nom']) ?></p>
        <?php if (!empty($reservation['photo_profil'])): ?>
            <img src="<?= htmlspecialchars($reservation['photo_profil']) ?>" alt="Photo du développeur">
        <?php endif; ?>
        <?php if (!empty($reservation['stack'])): ?>
            <p><strong>Stack :</strong> <?= htmlspecialchars($reservation['stack']) ?></p>
        <?php endif; ?>
        <?php if (!empty($reservation['description'])): ?>
            <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($reservation['description'])) ?></p>
        <?php endif; ?>
    </div>

    <div class="info">
        <h2>Informations sur votre réservation :</h2>
        <p><strong>Votre nom :</strong> <?= htmlspecialchars($reservation['fullname']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($reservation['email']) ?></p>
        <p><strong>Date de réservation :</strong> <?= htmlspecialchars($reservation['date_reservation']) ?></p>
        <p><strong>Heure de réservation :</strong> <?= htmlspecialchars($reservation['heure_reservation']) ?></p>
        <p><strong>Durée :</strong> <?= htmlspecialchars($reservation['duree']) ?></p>
        <?php if (!empty($reservation['commentaire'])): ?>
            <p><strong>Commentaire :</strong> <?= nl2br(htmlspecialchars($reservation['commentaire'])) ?></p>
        <?php endif; ?>
    </div>

    <p class="thank-you">Merci pour votre réservation !</p>
    <a href="../user/mes-reserv.php" class="home-button">Voir mes réservations</a>
</div>
</body>
</html>
