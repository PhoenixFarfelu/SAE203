<?php
session_start();
include 'scripts/fonctions.php';
parametre('img/icon1.png');

if (!isset($_SESSION['nom'])) {
    header('Location: connexion.php');
    exit();
}
<<<<<<< HEAD
entete();
navigation();
=======
parametre("", "", "" );
entete();
navigation();

>>>>>>> 315180749f469173830a3254605c8534c53b0c3a
?>