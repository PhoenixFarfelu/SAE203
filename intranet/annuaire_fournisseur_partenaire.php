<?php
session_start();
include 'scripts/fonctions.php';
parametre('img/logo1.png');

if (!isset($_SESSION['nom'])) {
    header('Location: connexion.php');
    exit();
}
navigation();
annuaire_partenaires();
?>
