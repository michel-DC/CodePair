<?php
session_start();

$chemin = $_SERVER['REQUEST_URI']; // on récupère l'URL ou l'user se situe par exemple https://co-working.michel.djoumessi.mmi-velizy.fr/connexion/login.php et on le stocke dans la variable $chemin -> ou je l'ai appris https://www.php.net/manual/fr/reserved.variables.server.php

if (!isset($_SESSION['connecté']) || $_SESSION['connecté'] !== true) { // vérifier si l'utilisateur est connecté

    if (strpos($chemin, 'index.php') !== false) { // si l'utilisateur veut aller sur index.php, on le laisse passer sans être connecté
        
    } else if (strpos($chemin, '/admin') !== false) { // si l'utilisateur veut aller sur /admin, on le redirige vers la page de connexion admin
        header('Location: ../connexion/login-admin.php?erreur=non_connecte');
        exit();
    } else if (strpos($chemin, 'devs.php') !== false) { // si l'utilisateur veut aller sur devs.php, on le redirige vers la page de connexion utilisateur normal
        header('Location: ../connexion/login.php?erreur=non_connecte');
        exit();
    }
}

// Si l'utilisateur connecté est "user" mais veut se connecter, je le bloque et redirige vers la page devs.php avec un message d'erreur
if (strpos($chemin, 'connexion/login.php') !== false && isset($_SESSION['connecté']) && $_SESSION['connecté'] === true && $_SESSION['role'] === 'user') {
    // Redirection vers la page devs.php si l'utilisateur est déjà connecté
    header('Location: ../devs.php?erreur=deja_connecte_user'); 
    exit();
}


// Si l'utilisateur connecté est "user" mais veut aller dans admin
if (strpos($chemin, '/admin') !== false && isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header('Location: ../connexion/login.php?erreur=acces_refuse_user');
    exit();
}

// Si l'utilisateur connecté est "admin" mais veut aller sur devs.php
if (strpos($chemin, 'devs.php') !== false && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header('Location: ../admin/dashboard.php?erreur=acces_interdit_admin');
    exit();
}
?>
