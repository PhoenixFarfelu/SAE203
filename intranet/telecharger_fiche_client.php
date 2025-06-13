<?php
session_start();
// Génère le contenu de la fiche
$contenu = " ---------------  Fiche Client  ---------------  \n\n";
$contenu .= " ---------------  " . $_POST['nom']."  ";
$contenu .= "" . $_POST['prenom'] . "  ---------------  \n";
$contenu .= "|_Adresse : " . $_POST['adresse'] . "\n";
$contenu .= "|_Téléphone : " . $_POST['telephone'] . "\n";
$contenu .= "|_Email : " . $_POST['email'] . "\n";
$contenu .= "|_Date : " . date("d/m/Y") . "\n";
// Prépare le téléchargement
$filename = "fiche_client_" . $_POST['nom'] ."_".$_POST['prenom']. ".txt";
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"$filename\"");
echo $contenu;
exit;

