<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connecté']) || $_SESSION['connecté'] !== true || $_SESSION['role'] !== 'user') {
    header("Location: ../connexion/login.php?erreur=non_connecte");
    exit();
}

$link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");

// Vérifier si l'ID de réservation est présent
if (!isset($_POST['id'])) {
    header("Location: ../user/mes-reserv.php");
    exit();
}

$reservation_id = $_POST['id'];

// Récupérer les infos de la réservation
$query = "SELECT r.*, d.fullname as dev_name 
          FROM reservations r 
          LEFT JOIN developpeurs d ON r.dev_id = d.id
          WHERE r.id = $reservation_id";
$result = mysqli_query($link, $query);
$reservation = mysqli_fetch_assoc($result);

// Traitement de l'annulation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $update_query = "UPDATE reservations SET statut = 'annulé' WHERE id = $reservation_id";
    mysqli_query($link, $update_query);
    header("Location: ../user/mes-reserv.php?success=annule");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuler une réservation</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap');
        * {
            font-family: "Space Grotesk", sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
            background-color:rgb(255, 255, 255); 
        }
        .card {
            overflow: hidden;
            position: relative;
            text-align: left;
            border-radius: 0.5rem;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            background-color: #fff;
            margin: auto; 
            padding: 30px;
        }

        .content {
            margin-top: 1.5rem;
            text-align: center;
        }

        .title {
            color: #ee0d0d;
            font-size: 1.5rem;
            font-weight: 600;
            line-height: 1.75rem;
            margin-bottom: 1rem;
        }

        .dev-name {
            color: #2ECC71;
            font-weight: 600;
            margin: 15px 0;
            font-size: 1.2rem;
        }

        .message {
            margin-top: 1rem;
            color: #595b5f;
            font-size: 1.1rem;
            line-height: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .actions {
            margin: 1.5rem 1rem;
            display: flex;
            gap: 15px;
        }

        .delete {
            cursor: pointer;
            display: inline-flex;
            padding: 0.75rem 1.5rem;
            background-color: #ee0d0d;
            color: #ffffff;
            font-size: 1.1rem;
            line-height: 1.5rem;
            font-weight: 500;
            justify-content: center;
            width: 100%;
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
        }

        .abandonner {
            cursor: pointer;
            display: inline-flex;
            padding: 0.75rem 1.5rem;
            color: #242525;
            font-size: 1.1rem;
            line-height: 1.5rem;
            font-weight: 500;
            justify-content: center;
            width: 100%;
            border-radius: 0.5rem;
            border: 1px solid #D1D5DB;
            background-color: #fff;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
            text-decoration: none;
            text-align: center;
        }
    </style>
</head>
<body>
    <section>
        <div class="card"> 
            <div class="content">
                <span class="title">Annuler une réservation</span> 
                <p class="dev-name">Développeur: <?= htmlspecialchars($reservation['dev_name']) ?> à <?= htmlspecialchars($reservation['heure_reservation']) ?></p>
                <p class="message">Êtes-vous sûr de vouloir annuler votre réservation ?</p> 
            </div> 
            <div class="actions">
                <form method="POST" style="width: 100%;">
                    <input type="hidden" name="id" value="<?= $reservation_id ?>">
                    <input type="hidden" name="confirm_delete" value="1">
                    <button class="delete" type="submit">Confirmer</button>
                </form>
                <a href="../user/mes-reserv.php" class="abandonner">Anuler</a>
            </div> 
        </div>
    </section>
</body>
</html>