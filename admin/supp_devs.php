<?php require_once '../includes/auth.php'; ?>

<?php
$link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");

// Recuperer la liste des développeurs
$query = "SELECT id, fullname FROM developpeurs ORDER BY fullname ASC";
$result = mysqli_query($link, $query);
$developpeurs = [];
while($row = mysqli_fetch_assoc($result)) {
    $developpeurs[] = $row;
}

// Traitement du formulaire de suppression
if (isset($_POST['supp_developpeur'])) {
    $id = $_POST['id'];

    // Verifier si le développeur existe
    $query = "SELECT * FROM developpeurs WHERE id = $id";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0) {
        // Supprimer le développeur
        $query = "DELETE FROM developpeurs WHERE id = $id";
        if (mysqli_query($link, $query)) {
            $success = "Développeur supprimé avec succès !";
            // Rafraîchir la liste des développeurs après suppression
            $query = "SELECT id, fullname FROM developpeurs ORDER BY fullname ASC";
            $result = mysqli_query($link, $query);
            $developpeurs = [];
            while($row = mysqli_fetch_assoc($result)) {
                $developpeurs[] = $row;
            }
        } else {
            $error = "Erreur lors de la suppression du développeur.";
        }
    } else {
        $error = "Aucun développeur trouvé avec cet ID.";
    }
}
?>

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

        .form-container {
            border: 1px lightgreen solid;
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 45px;
            color: #151717;
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

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #111827;
            font-weight: 500;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background-color: white;
            font-size: 0.9rem;
            color: #4b5563;
        }

        .btn {
            background-color: #ff4444;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .btn:hover {
            background-color: rgb(118, 244, 171);
        }

        .message {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            max-width: 600px;
        }
    </style>

<div class="container">
    <div class="form-container">
        <h2>Supprimer un <span>développeur</span></h2>
        
        <?php if (isset($success)): ?>
            <div class="message success"><?= $success ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="message error"><?= $error ?></div>
        <?php endif; ?>

        <form action="dashboard.php#supp-dev-section" method="POST">
            <div class="form-group">
                <label for="id">Sélectionnez un développeur à supprimer</label>
                <select name="id" id="id" required>
                    <option value="">-- Choisissez un développeur --</option>
                    <?php foreach ($developpeurs as $developpeur): ?>
                        <option value="<?= $developpeur['id'] ?>"><?= $developpeur['fullname'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="supp_developpeur" class="btn">Supprimer</button>
        </form>
    </div>
</div>