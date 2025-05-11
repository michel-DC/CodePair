<?php
// Connexion à la base de données
$link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");

// Récupérer toutes les réservations
$query = "SELECT * FROM reservations ORDER BY date_creation DESC";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des réservations</title>
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
            margin-top: 100px;
            padding: 20px;
        }
        h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 45px;
            color: #151717;
            text-align: center;
        }
        h2 span {
            color: #2ECC71;
            position: relative;
        }
        h2 span::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #2ECC71;
            border-radius: 3px;
        }
        .mdc-table {
            width: 100%;
            margin: 0 auto;
            border-collapse: separate;
            border-spacing: 0 8px;
            font-size: 0.9rem;
            background: transparent;
        }
        .mdc-table th {
            background-color: #f8f9fa;
            color: #666;
            font-weight: 500;
            padding: 12px 20px;
            text-align: left;
            border: none;
        }
        .mdc-table td {
            background: white;
            padding: 12px 20px;
            color: #333;
            border: none;
        }
        .mdc-table tr td:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }
        .mdc-table tr td:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }
        .status-confirme {
            background-color: #e3f3e6;
            color: #2da44e;
        }

        .status-annule {
            background-color:rgb(249, 209, 222);
            color:rgb(211, 10, 16);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Liste des <span>réservations</span></h2>
        <table class="mdc-table">
            <thead>
                <tr>
                    <th>ID Réservation</th>
                    <th>ID Developpeur</th>
                    <th>ID Utilisateur</th>
                    <th>Nom de l'user</th>
                    <th>Email</th>
                    <th>Date réservation</th>
                    <th>Date création</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php while($res = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($res['id']) ?></td>
                        <td><?= htmlspecialchars($res['dev_id']) ?></td>
                        <td><?= htmlspecialchars($res['user_id']) ?></td>
                        <td><?= htmlspecialchars($res['fullname']) ?></td>
                        <td><?= htmlspecialchars($res['email']) ?></td>
                        <td><?= htmlspecialchars($res['date_reservation']) ?></td>
                        <td><?= htmlspecialchars($res['date_creation']) ?></td>
                        <td>
                            <span class="status-badge <?= $res['statut'] === 'confirmé' ? 'status-confirme' : 'status-annule' ?>"> <!-- Ici ce span prend une class diférente en fonction de la valeur de status, si le status est confirmé alors il prend la class "status-confirmé" et si le status est annulé, il prend la class "annulé" -->
                                <?= htmlspecialchars($res['statut']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
