<?php
session_start();
include 'scripts/fonctions.php';
parametre('CoVoitVoit','images/icon.png','');

if (!isset($_SESSION['nom'])) {
    header('Location: connexion.php');
    exit();
}
?>


<a href="deconnexion.php" class="btn btn-outline-dark btn-sm mt-2 mt-sm-0">Se déconnecter</a>