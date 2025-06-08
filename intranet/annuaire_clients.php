<?php
session_start();
include 'scripts/fonctions.php';
parametre('img/icon1.png');

if (!isset($_SESSION['nom'])) {
    header('Location: connexion.php');
    exit();
}
parametre("", "", "" );
navigation();
annuaire_client_ameliore();
?>


