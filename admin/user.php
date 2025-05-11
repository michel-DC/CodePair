<?php require_once '../includes/auth.php'; ?>

<?php

$link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");

// Récupérer la liste des développeurs
$query = "SELECT id, fullname FROM users ORDER BY fullname ASC";
$result = mysqli_query($link, $query);
$users = [];
while($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

// Récupérer tous les détails des utilisateurs pour le tableau
$query_all = "SELECT * FROM users ORDER BY fullname ASC";
$result_all = mysqli_query($link, $query_all);

// Traitement du formulaire de suppression
if (isset($_POST['supp_utilisateur'])) {
    $id = $_POST['user_id'];

    // Vérifier si le user existe
    $query = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0) {
        // Supprimer le user
        $query = "DELETE FROM users WHERE id = $id";
        if (mysqli_query($link, $query)) {
            $success = "Utilisateur supprimé avec succès !";
            // Rafraîchir la liste des développeurs après suppression
            $query = "SELECT id, fullname FROM users ORDER BY fullname ASC";
            $result = mysqli_query($link, $query);
            $users = [];
            while($row = mysqli_fetch_assoc($result)) {
                $users[] = $row;
            }
        } else {
            $error = "Erreur lors de la suppression de l'utilisateur.";
        }
    } else {
        $error = "Aucun utilisateur trouvé avec cet ID.";
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
            margin-bottom: 50px;
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
            background-color: #2ECC71;
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
            background-color:rgb(118, 244, 171);
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

        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
    </style>

<div class="container">
    <div class="form-container">
        <h2>Supprimer un <span>utilisateur</span></h2>
        
        <?php if (isset($success)): ?>
            <div class="message success"><?= $success ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="message error"><?= $error ?></div>
        <?php endif; ?>

        <form action="dashboard.php#see-user-section" method="POST">
            <div class="form-group">
                <label for="user_id">Sélectionnez un utilisateur à supprimer</label>
                <select name="user_id" id="user_id" required>
                    <option value="">-- Choisissez un utilisateur --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>"><?= $user['fullname'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="supp_utilisateur" class="btn">Supprimer</button>
        </form>
    </div>

    <h2>Liste des <span>utilisateurs</span></h2>
    <table class="mdc-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom complet</th>
                <th>Email</th>
                <th>Date d'inscription</th>
                <th>Nombre de réservations</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = mysqli_fetch_assoc($result_all)): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['fullname']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['date_creation']) ?></td>
                    <td><?= htmlspecialchars($user['nombre_reservation']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>