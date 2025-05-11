<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connecté']) || $_SESSION['connecté'] !== true || $_SESSION['role'] !== 'user') {
    header("Location: ../connexion/login.php?erreur=non_connecte");
    exit();
}

// Connexion à la base de données
$link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");

// Récupérer les réservations de l'utilisateur connecté
$user_id = $_SESSION['user_id'];
$query = "SELECT r.*, d.fullname as dev_name 
          FROM reservations r 
          LEFT JOIN developpeurs d ON r.dev_id = d.id
          WHERE r.user_id = $user_id 
          ORDER BY r.date_creation DESC";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Réservations</title>
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

        header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #ffffff;
            z-index: 1000;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: 600;
            color: #151717;
        }

        .logo span {
            color: #2ECC71;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        nav ul li a {
            text-decoration: none;
            color: #151717;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color:rgb(145, 231, 181);
        }

        .user-dropdown {
            position: relative;
            display: inline-block;
            margin-left: auto;
            cursor: pointer;
        }

        .user-icon {
            color: #333;
            transition: transform 0.2s ease;
        }

        .user-dropdown:hover .user-icon {
            transform: scale(1.1);
        }

        .dropdown-menu {
            position: absolute;
            top: 35px;
            right: 0;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            list-style: none;
            padding: 10px 0;
            width: 180px;
            display: none;
            z-index: 100;
        }

        .user-dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu li {
            padding: 10px 20px;
        }

        .dropdown-menu li a {
            text-decoration: none;
            color: #333;
        }

        .dropdown-menu li:hover {
            background-color: #f2f2f2;
        }

        .user-name {
            color: #2ECC71;
            position: relative;
        }

        .user-name::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #2ECC71;
            border-radius: 3px;
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

        .no-reservations {
            text-align: center;
            padding: 40px;
            color: #666;
            background: white;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
<header>
        <div class="header-container">
            <div class="logo">Code<span>Pair</span></div>
            <nav>
                <ul>
                    <li><a href="../index.php">Accueil</a></li>
                    <li><a href="../devs.php">Réserver un développeur</a></li>
                    <?php if (empty($_SESSION['connecté'])): ?>
                        <li><a href="../connexion/login.php">Connexion</a></li>
                    <?php endif; ?>

                    <li>
                    <?php if (isset($_SESSION['connecté']) && $_SESSION['connecté'] === true && $_SESSION['role'] === 'user'): ?>
                    <div class="user-dropdown">
                        <svg class="user-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        <ul class="dropdown-menu">
                        <?php if (isset($_SESSION['fullname'])): ?>
                            <li><a href="#">Bienvenue <span class="user-name"><?= htmlspecialchars($_SESSION['fullname']) ?></span></a></li>
                        <?php endif; ?>
                            <li><a href="mes-reserv.php">Mes Réservations</a></li>
                            <li><a href="../connexion/logout-user.php">Se Déconnecter</a></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <h2>Mes <span>réservations</span></h2>
        <?php if(mysqli_num_rows($result) > 0): ?>
            <table class="mdc-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Développeur</th>
                        <th>Date réservation</th>
                        <th>Heure réservation</th>
                        <th>Durée</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($res = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($res['id']) ?></td>
                            <td><?= htmlspecialchars($res['dev_name']) ?></td>
                            <td><?= htmlspecialchars($res['date_reservation']) ?></td>
                            <td><?= htmlspecialchars($res['heure_reservation']) ?></td>
                            <td><?= htmlspecialchars($res['duree']) ?></td>
                            <td>
                                <span class="status-badge <?= $res['statut'] === 'confirmé' ? 'status-confirme' : 'status-annule' ?>">
                                    <?= htmlspecialchars($res['statut']) ?>
                                </span>
                            </td>
                        <?php if ($res['statut'] === 'confirmé'): ?>
                        <td>
                            <form action="../reservation/delete.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $res['id'] ?>">
                                <button type="submit" class="btn-delete">
                                    <a href="../reservation/delete.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                    </a>
                                </button>
                            </form>
                        </td>
                        <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-reservations">
                <p>Vous n'avez pas encore de réservations.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
