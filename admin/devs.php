<?php require_once '../includes/auth.php'; ?>

<?php
// Connexion à la base de données
$link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");

// Récupérer tous les développeurs
$query = "SELECT * FROM developpeurs";
$result = mysqli_query($link, $query);

// Traitement de la recherche
if (isset($_POST['search_dev'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM developpeurs WHERE fullname LIKE '%$search%' OR stack LIKE '%$search%'";
    $result = mysqli_query($link, $query);
}

if (isset($_POST['see_dev'])) {
    $query = "SELECT * FROM developpeurs";
    $result = mysqli_query($link, $query);
}
?>


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap');
        .container {
            font-family: "Space Grotesk", sans-serif; 
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 20px;
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

        form {
            display: flex;
            gap: 10px;
            margin-bottom: 60px;
        }

        form input[type="text"] {
            padding: 10px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            font-family: "Space Grotesk", sans-serif;
            flex-grow: 1;
        }

        form button {
            padding: 10px 20px;
            background-color: #2ECC71;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-family: "Space Grotesk", sans-serif;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        form button:hover {
            background-color: #25a25a;
        }
        
        .developers-grid {
            display: flex;
            flex-wrap: wrap;
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
            flex-direction: column row-reverse;
            width: calc(33.33% - 14px); 
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
        
        .dev-stack {
            font-size: 0.8rem;
            font-weight: bolder;
            color: #6b7280;
            margin-bottom: 10px;
        }
    </style>

<div class="container">
    <h1>Les développeurs <span>disponibles</span></h1>
    
    <form method="POST" action="dashboard.php#see-dev-section">
        <input type="text" name="search" placeholder="Rechercher un développeur...">
        <button type="submit" name="search_dev">Rechercher</button>
        <button type="submit" name="see_dev">Voir tous les developpeurs/euses</button>
    </form>

    <div class="developers-grid">
        <?php 
        if (mysqli_num_rows($result) > 0) {
            while($dev = mysqli_fetch_assoc($result)): ?>
                <div class="dev-card">
                    <img class="dev-avatar" src="<?= $dev['photo_profil'] ?>" alt="<?= $dev['fullname'] ?>">
                    <div class="dev-content">
                        <h3 class="dev-title"><?= $dev['fullname'] ?></h3>
                        <p class="dev-description"><?= $dev['description'] ?></p>
                        <div class="dev-stack">Stack : <?= $dev['stack'] ?></div>
                    </div>
                </div>
            <?php endwhile; 
        } else {
            echo "<p>Aucun développeur trouvé pour votre recherche.</p>";
        }
        ?>
    </div>
</div>