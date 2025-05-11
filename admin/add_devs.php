<?php require_once '../includes/auth.php'; ?>

<?php

$link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");

if (isset($_POST['ajt_developpeur'])) {
    $fullname = $_POST['fullname'];
    $stack = $_POST['stack'];
    $description = $_POST['description'];

    // upload image
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $dossier = '../images/';

        $filename = basename($_FILES['profile_picture']['name']);
        $destination = $dossier . uniqid() . '_' . $filename;
        $type_fichier = mime_content_type($_FILES['profile_picture']['tmp_name']);

        $type_autorise = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($type_fichier, $type_autorise)) {
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $destination)) {
                $query = "INSERT INTO developpeurs (fullname, stack, description, photo_profil)
                          VALUES ('$fullname', '$stack', '$description', '$destination')";

                if (mysqli_query($link, $query)) {
                    $success = "Développeur ajouté avec succès !";
                } else {
                    $error = "Erreur lors de l'insertion en base de données.";
                }
            } else {
                $error = "Erreur lors du déplacement de l'image.";
            }
        } else {
            $error = "Type de fichier non autorisé. Seuls les JPG, PNG et GIF sont acceptés.";
        }
    } else {
        $error = "Erreur lors de l'upload de l'image.";
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

        .form-container {
            border: 1px lightgreen solid;
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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

        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background-color: white;
            font-size: 0.9rem;
            color: #4b5563;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
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

        input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background-color: white;
        }

        .language-icon {
            width: 50px;
            height: 50px;
            margin: 5px;
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 5px;
            transition: border-color 0.2s ease;
        }

        .language-icon.selectionne {
            border-color: #2ECC71;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            max-width: 600px;
        }
    </style>

<div class="container">
    <h1>Ajouter un <span>développeur</span></h1>
    <div class="form-container">
        <?php if (isset($success)): ?>
            <div class="message success"><?= $success ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="message error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" action="dashboard.php#add-dev-section">
            <div class="form-group">
                <label for="fullname">Nom complet</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>
            
            <div class="form-group">
                <label for="stack">Stack technique: choisissez parmi les langages ci-dessous</label>
                <div id="selection-langages">
                    <img src="https://icons.iconarchive.com/icons/cornmanthe3rd/metronome/512/Other-html-5-icon.png" data-lang="HTML" alt="HTML" class="language-icon">
                    <img src="https://cdn-icons-png.flaticon.com/512/5968/5968242.png" data-lang="CSS" alt="CSS" class="language-icon">
                    <img src="https://img.icons8.com/color/512/javascript.png" data-lang="Javascript" alt="Javascript" class="language-icon">
                    <img src="https://cdn.iconscout.com/icon/free/png-256/free-php-99-1175127.png?f=webp" data-lang="PHP" alt="PHP" class="language-icon">
                    <img src="https://img.icons8.com/?size=512&id=39858&format=png" data-lang="MySQL" alt="MySQL" class="language-icon">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/React-icon.svg/1150px-React-icon.svg.png" data-lang="ReactJS" alt="ReactJS" class="language-icon">
                    <img src="https://static-00.iconduck.com/assets.00/vue-js-icon-2048x1766-btrgkrhi.png" data-lang="VueJS" alt="VueJS" class="language-icon">
                    <img src="https://static-00.iconduck.com/assets.00/next-js-icon-2048x2048-5dqjgeku.png" data-lang="NextJS" alt="NextJS" class="language-icon">
                </div>
                <input type="hidden" id="stack" name="stack">
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="profile_picture">Photo de profil</label>
                <input type="file" id="profile_picture" name="profile_picture" required>
            </div>
            
            <button type="submit" name="ajt_developpeur" class="btn">Ajouter le développeur</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lesLangages = document.getElementById('stack'); // on récupère l'id du champ caché
        const langagesSelectionne = []; // les langages sélectionnés dans un tableau

        document.querySelectorAll('.language-icon').forEach(function(icon) {
            icon.addEventListener('click', function() {
                const lang = this.getAttribute('data-lang');
                this.classList.toggle('selectionne'); // au clic d'une icône de langage, on lui donne la propriété de sélectionné

                if (this.classList.contains('selectionne')) { // si le langage est sélectionné, il est ajouté au tableau
                    langagesSelectionne.push(lang);
                } else {
                    const index = langagesSelectionne.indexOf(lang);
                    if (index !== -1) { // sinon il est supprimé
                        langagesSelectionne.splice(index, 1);
                    }
                }

                lesLangages.value = langagesSelectionne.join(', '); // les langages sélectionnés sont joints dans une chaîne de caractères séparée par une virgule
            });
        });
    });
</script>