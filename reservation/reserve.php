<?php
session_start();
$link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connecté']) || $_SESSION['connecté'] !== true || $_SESSION['role'] !== 'user') {
    header("Location: login.php?erreur=non_connecte");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['dev_id'])) {
    echo "Aucun développeur sélectionné.";
    exit();
}

$dev_id = intval($_GET['dev_id']);

// Récupérer les infos du développeur dans la bonne table
$query_dev = "SELECT * FROM developpeurs WHERE id = $dev_id";
$result_dev = mysqli_query($link, $query_dev);

if (!$result_dev || mysqli_num_rows($result_dev) === 0) {
    echo "Développeur non trouvé.";
    exit();
}

$dev = mysqli_fetch_assoc($result_dev);

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $date_reservation = $_POST['date_reservation'];
    $heure_reservation = $_POST['heure_reservation'];
    $duree = $_POST['duree'];
    $commentaire = $_POST['commentaire'];

    // Vérifier si le développeur est déjà réservé à cette date
    $query_check = "SELECT COUNT(*) as total FROM reservations WHERE dev_id = $dev_id AND date_reservation = '$date_reservation'";
    $result_check = mysqli_query($link, $query_check);
    $row_check = mysqli_fetch_assoc($result_check);

    if ($row_check['total'] > 0) {
        $error = "Ce développeur est déjà réservé à cette date. Veuillez choisir une autre date.";
    } else {
        // Vérifier si l'heure est entre 8h et 22h
        $heure = intval(substr($heure_reservation, 0, 2));  // substr extrait les deux premiers caractères de la chaine $heure_reservation ensuite intval convertit ces caractères en entier
        if ($heure < 8 || $heure >= 22) {
            $error = "Les réservations ne sont possibles qu'entre 8h00 et 22h00";
        } else {
            $query_insert = "
                INSERT INTO reservations (user_id, dev_id, fullname, email, date_reservation, heure_reservation, duree, commentaire)
                VALUES ($user_id, $dev_id, '$fullname', '$email', '$date_reservation', '$heure_reservation', '$duree', '$commentaire')
            ";

            if (mysqli_query($link, $query_insert)) {
                $reservation_id = mysqli_insert_id($link);
                header("Location: details.php?id=$reservation_id");
                exit();
            } else {
                $error = "Erreur lors de la réservation : " . mysqli_error($link);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réserver -> <?= htmlspecialchars($dev['fullname']) ?></title>
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
            padding: 20px;
        }

        .dev-info {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .dev-info img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .form-reservation {
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .form-reservation label {
            font-weight: 500;
            color: #333;
        }

        .form-reservation input,
        .form-reservation select,
        .form-reservation textarea {
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background: #fff;
            transition: border-color 0.3s ease;
        }

        .form-reservation input:focus,
        .form-reservation select:focus,
        .form-reservation textarea:focus {
            border-color: #2ECC71;
            outline: none;
        }

        .form-reservation button {
            background-color: #2ECC71;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-reservation button:hover {
            background-color:rgb(151, 127, 246);
        }

        .error {
            color: #dc3545;
            background: #f8d7da;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="dev-info">
        <h2>Réserver: <?= htmlspecialchars($dev['fullname']) ?></h2>
        <?php if (!empty($dev['stack'])): ?>
            <p><strong>Stack :</strong> <?= htmlspecialchars($dev['stack']) ?></p>
        <?php endif; ?>
        <?php if (!empty($dev['description'])): ?>
            <p><strong>Description :</strong> <?= (htmlspecialchars($dev['description'])) ?></p>
        <?php endif; ?>
        <?php if (!empty($dev['photo_profil'])): ?>
            <img src="<?= htmlspecialchars($dev['photo_profil']) ?>" alt="Photo du développeur">
        <?php endif; ?>
    </div>

    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form class="form-reservation" method="POST">
        <label for="nom">Votre nom complet:</label>
        <input type="text" name="fullname" placeholder="Votre nom complet" required value="<?= htmlspecialchars($_SESSION['fullname']) ?>">
        <label for="email">Votre email:</label>
        <input type="email" name="email" placeholder="Votre email" required value="<?= htmlspecialchars($_SESSION['email']) ?>">
        <label for="date_reservation">Pour quand voulez vous réserver :</label>
        <input type="date" name="date_reservation" required>
        <label for="heure_reservation">À quelle heure (entre 8h00 et 22h00) :</label>
        <input type="time" name="heure_reservation" min="08:00" max="22:00" required>
        <label for="duree">Pour une durée de :</label>
        <select name="duree" required>
            <option value="1 heure">1 heure</option>
            <option value="2 heures">2 heures</option>
            <option value="3 heures">3 heures</option>
        </select>
        <label for="commenataire">Un petit commentaire pour le développeur :</label>
        <textarea name="commentaire" rows="4" placeholder="Pourquoi ce développeur ? (facultatif)"></textarea>
        <button type="submit">Confirmer la réservation</button>
    </form>
</div>

</body>
</html>
