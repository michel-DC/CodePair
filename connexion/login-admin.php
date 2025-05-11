<!-- page de login admin avec deux champs un username et un password

l'username et de password seront déja présents dans la base de données donc impossible de crée un compte admin

si l'username et le password sont corrects alors on affiche un message de bienvenue et on redirige vers le dashboard admin

si l'username et le password sont incorrects alors on affiche un message d'erreur et on redirige vers la page de login admin -->
<?php session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter en admin</title>
    <link rel="shortcut icon" href="../assets/images/icon/codepair_icon.PNG" type="image/x-icon"></link>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap');
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
            background-color: #ffffff; 
        }
        .form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            background-color: #ffffff;
            border: 2px solid black;
            padding: 30px;
            width: 450px;
            border-radius: 20px;
            font-family: "Space Grotesk", sans-serif; 
        }

        ::placeholder {
            font-family: "Space Grotesk", sans-serif; 
        }

        .form button {
            align-self: flex-end;
        }

        .span-purple {
            color: #2ECC71;
            position: relative;
        }

        .span-purple::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #2ECC71;
            border-radius: 3px;
        }

        .flex-column > label {
            color: #151717;
            font-weight: 600;
        }

        .inputForm {
            border: 1.5px solid #ecedec;
            border-radius: 10px;
            height: 50px;
            display: flex;
            align-items: center;
            padding-left: 10px;
            transition: 0.2s ease-in-out;
        }

        .input {
            margin-left: 10px;
            border-radius: 10px;
            border: none;
            width: 100%;
            height: 100%;
        }

        .input:focus {
            outline: none;
        }

        .inputForm:focus-within {
            border: 1.5px solid #2d79f3;
        }

        .flex-row {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
            justify-content: space-between;
        }

        .flex-row > div > label {
            font-size: 14px;
            color: black;
            font-weight: 400;
        }

        .span {
            font-size: 14px;
            margin-left: 5px;
            color: #2d79f3;
            font-weight: 500;
            cursor: pointer;
        }

        .button-submit {
            margin: 20px 0 10px 0;
            background-color: #151717;
            border: none;
            color: white;
            font-size: 15px;
            font-weight: 500;
            border-radius: 10px;
            height: 50px;
            width: 100%;
            cursor: pointer;
        }

        .p {
            text-align: center;
            color: black;
            font-size: 14px;
            margin: 5px 0;
        }

        .btn {
            margin-top: 10px;
            width: 100%;
            height: 50px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 500;
            gap: 10px;
            border: 1px solid #ededef;
            background-color: white;
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }

        .btn:hover {
            border: 1px solid #2d79f3;
        }

        .message {
            padding: 10px;
            border-radius: 5px;
            margin: 10px auto;
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
    <section>
        <form class="form" method="POST" action="login-admin.php">
        <a href="../index.php" class="home-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
        </a>
            <h1 style="text-align: center;" >Se connecter en <span class="span-purple">admin</span></h1>
            <div class="flex-column">
                <label>Nom d'utilisateur </label>
            </div>
            <div class="inputForm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" height="20">
                    <path d="M12 4a4 4 0 0 1 4 4 4 4 0 0 1-4 4 4 4 0 0 1-4-4 4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4z"></path>
                </svg>
                <input placeholder="Entrez votre Nom d'utilisateur admin" class="input" type="text" name="admin_username">
            </div>

            <div class="flex-column">
                <label>Mot de passe </label>
            </div>
            <div class="inputForm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
                    <path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path>
                    <path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
                </svg>
                <input placeholder="Entrer votre Mot de passe admin" class="input" type="password" name="admin_password">
            </div>

            <button class="button-submit" name="login_admin">Se Connecter</button>
            <p class="p">Vous n'êtes pas administrateur ? <span class="span"><a href="login.php">Connectez vous en tant que utilisateur</a></span></p>
        </form>
    </section>

    <?php
    $link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");

    if (isset($_POST['login_admin'])) {
        $username = $_POST['admin_username'];
        $password = $_POST['admin_password'];
    
        $query = "SELECT * FROM admins WHERE username='$username'";
        $result = mysqli_query($link, $query);
        
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                if ($password === $user['password']) {  
                    $_SESSION['connecté'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = 'admin';
                    $success = "Vous êtes connecté en tant que $username, redirection en cours...";
                    echo "<meta http-equiv='refresh' content='3;url=../admin/dashboard.php'>"; // redirection après 3s vers la page /admin/dashboard
                } else {
                    $error = "Mot de passe incorrect";
                }
            } else {
                $error = "Ton compte n'existe pas, sorry :(";
            }
        }
    }

    if (isset($error)): // si l'erreur existe alors on affiche le message d'erreur
        echo "<div class='message error'>$error</div>";
    endif;

    if (isset($success)): // si le succès existe alors on affiche le message de succès
        echo "<div class='message success'>$success</div>";
    endif;


    if (isset($_GET['erreur']) && $_GET['erreur'] === 'non_connecte') { // ici on vérifie si l'url contient login-admin.php OU /admin
    $chemin = $_SERVER['REQUEST_URI'];

    if (strpos($chemin, 'login-admin.php') !== false || strpos($chemin, '/admin') !== false) { // si la page actuelle est login-admin.php OU si on vient de /admin
        echo "<div class='message error'>Vous devez obligatoirement être connecté en tant qu'admin pour accéder à cette page</div>";
    } 
}
    // gestion de la deconnexion 
    if (isset($_GET['message']) && $_GET['message'] === 'deconnexion_admin') {
        echo "<div class='message success'>Déconnexion réussie. À bientôt !</div>";
    }

    ?>
</body>
</html>



