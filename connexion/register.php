<?php
require_once '../includes/auth.php';

$link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");


    if (isset($_POST['register_user'])) {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

        if ($_POST['password'] != $_POST['password_confirm']) {
            $error_password = "Les mots de passe ne correspondent pas, veuillez réessayer";
        }
    
        $query = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";
        if (mysqli_query($link, $query)) {
            $success = "Félicitations $fullname, votre compte a bien été créé :), vous pouvez maintenant vous connecter";
        } else {
            $error = "Malheuresement, il y a une erreur, veuillez réessayer";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link rel="shortcut icon" href="../assets/images/icon/codepair_icon.PNG" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap');
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
            background-color: #ffffff;
            font-family: "Space Grotesk", sans-serif; 
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
        <form class="form" method="POST" action="register.php">
        <a href="../index.php" class="home-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
        </a>
        <h1 style="text-align: center;" >Créer un <span class="span-purple">compte</span></h1>
            <div class="flex-column">
                <label>Nom et Prénom </label>
            </div>
            <div class="inputForm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" height="20">
                    <path d="M12 4a4 4 0 0 1 4 4 4 4 0 0 1-4 4 4 4 0 0 1-4-4 4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4z"></path>
                </svg>
                <input placeholder="Entrez votre nom et prénom" class="input" type="text" name="fullname">
            </div>

            <div class="flex-column">
                <label>Email </label>
            </div>
            <div class="inputForm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20">
                    <g data-name="Layer 3" id="Layer_3">
                        <path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path>
                    </g>
                </svg>
                <input placeholder="Entrez votre Email" class="input" type="text" name="email">
            </div>

            <div class="flex-column">
                <label>Mot de passe </label>
            </div>
            <div class="inputForm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
                    <path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path>
                    <path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
                </svg>
                <input placeholder="Mot de passe" class="input" type="password" name="password">
            </div>
            <div class="flex-column">
                <label>Confirmez votre Mot de passe </label>
            </div>
            <div class="inputForm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
                    <path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path>
                    <path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
                </svg>
                <input placeholder="Mot de passe" class="input" type="password" name="password_confirm">
            </div>

            <button class="button-submit" name="register_user">S'inscrire</button>
            <p class="p">Vous avez déjà un compte<span class="span"><a href="login.php">Se connecter</a></span></p>
        </form>
    </section>

    <?php

    if (isset($error)): 
        echo "<div class='message error'>$error</div>";
    endif; 
    
    if (isset($success)):
        echo "<div class='message success'>$success</div>";
    endif; 

    if (isset($error_password)):
        echo "<div class='message error'>$error_password</div>";
    endif; 

    if (isset($_GET['erreur']) && $_GET['erreur'] === 'deja_connecte_user') {
        echo "<div class='message error'>Vous êtes déjà connecté, si vous voulez changer de compte, déconnectez-vous d'abord</div>";
    }

    ?>
</body>
</html>