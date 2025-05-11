<?php 
require_once 'includes/auth.php'; 

if (isset($_GET['erreur']) && $_GET['erreur'] === 'deja_connecte_user') {
    echo "<div class='message error'>Vous êtes déjà connecté, si vous voulez changer de compte, déconnectez-vous d'abord</div>";
}

// Connexion à la base de données
$link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");

// Récupérer tous les développeurs
$query = "SELECT * FROM developpeurs";
$result = mysqli_query($link, $query);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodePair | Développeurs Disponibles</title>
    <link rel="shortcut icon" href="../assets/images/icon/codepair_icon.PNG" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap');
        body {
            font-family: "Space Grotesk", sans-serif;
            box-sizing: border-box;
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

        /* dropdown menu */
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
        /* dropdown menu */

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

        .container h1 {
            font-size: 36px;
            font-weight: 700;
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
        
        .page-title {
            text-align: center;
            margin-bottom: 40px;
            color: #2d3748;
            font-size: 2rem;
        }
        
        .developers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .dev-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .dev-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .dev-content {
            padding: 20px 15px 15px;
            flex-grow: 1;
        }
        
        .dev-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #111827;
        }
        
        .dev-description {
            font-size: 0.9rem;
            color: #4b5563;
            margin-bottom: 12px;
            line-height: 1.4;
        }
        
        
        .dev-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            position: absolute;
            top: 10px;
            right: 10px;
            border: 2px solid white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .action-bar {
            display: flex;
            padding: 10px 15px;
            background: #f3f4f6;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e5e7eb;
        }

        .action-bar a {
            text-decoration: none;
        }
        
        .reserve-btn {
            background: #2ECC71;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 6px 16px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
            text-align: center;
        }
        
        .reserve-btn:hover {
            background:rgb(142, 245, 185);
        }
        
        .dev-stack {
            font-size: 0.8rem;
            font-weight: bolder;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .div-green-text {
            font-size: 0.9rem;
            font-weight: bold;
            display: inline;
        }

        .green-text {
            font-size: 0.9rem;
            font-weight: bold;
            color: green;
            display: inline;
        }

        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
        }

        .message {
            z-index: 20;
            padding: 10px;
            border-radius: 5px;
            margin: 10px auto;
            margin-top: 100px;
            text-align: center;
            width: 90%;
            max-width: 450px;
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            animation: fadeOut 5s forwards;
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; display: none; }
        }

        .error {
            background-color: #ffebee;
            color: #c62828;
        }

        .success {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
    </style>
</head>
<body>

    <header>
        <div class="header-container">
            <div class="logo">Code<span>Pair</span></div>
            <nav>
                <ul>

                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="devs.php">Réserver un développeur</a></li>
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
                            <li><a href="#">Bienvenue <span class="user-name"><?= htmlspecialchars($_SESSION['fullname']) ?></span></a></li> <!-- html special char sert à mettre du html dans du php pour conserver leur signification https://www.php.net/manual/fr/function.htmlspecialchars.php -->
                        <?php endif; ?>
                            <li><a href="../user/mes-reserv.php">Mes Réservations</a></li>
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
        <h1 class="page-title">Nos développeurs <span>disponibles</span></h1>
        
        <div class="developers-grid">
            <?php while($dev = mysqli_fetch_assoc($result)): ?>
                <div class="dev-card">
                    
                    <img class="dev-avatar" src="<?= $dev['photo_profil'] ?>" alt="<?= $dev['fullname'] ?>">
                    
                    <div class="dev-content">
                        <h3 class="dev-title"><?= $dev['fullname'] ?></h3>
                        
                        <p class="dev-description"><?= $dev['description'] ?></p>
                        
                        <div class="dev-stack">Langages utilisés : <?= $dev['stack'] ?></div>

                        <p class="div-green-text">Ce développeur à été réservé<p class="green-text"> <?= $dev['nombre_reservation'] ?> fois</p>
                        
                    </div>
                    
                    <div class="action-bar">
                        <a href="/reservation/reserve.php?dev_id=<?= $dev['id'] ?>" class="reserve-btn">Réserver 👨‍💻</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>
</html>