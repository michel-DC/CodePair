<?php
session_start();

// Vider toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion
header('Location: login.php?message=deconnexion_user');
exit();
?>
