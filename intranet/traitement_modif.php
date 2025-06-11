<?php
session_start();
include 'scripts/fonctions.php';
$data = read("data/annuaires/entreprise.json", $JSON=true);

$data[$_POST['submit']]['nom'] = $_POST['nom'];
$data[$_POST['submit']]['prenom'] = $_POST['prenom'];
$data[$_POST['submit']]['fonction'] = $_POST['fonction'];
$data[$_POST['submit']]['email'] = $_POST['email'];
$data[$_POST['submit']]['bio'] = $_POST['bio'];

// Supprimer l'ancienne photo si elle existe
if (!empty($data[$_POST['submit']]['photo'])) {
    $oldPhotoPath = "data/annuaires/photo/" . $data[$_POST['submit']]['photo'];
    if (file_exists($oldPhotoPath)) {
        unlink($oldPhotoPath);
    }
}

// Gestion de l'upload de la nouvelle photo
if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
    $filename = $data[$_POST['submit']]['photo'];
    move_uploaded_file($_FILES["photo"]["tmp_name"], "data/annuaires/photo/" . $filename);
    $data[$_POST['submit']]['photo'] = $filename;
}
file_put_contents("data/annuaires/entreprise.json", json_encode($data, JSON_PRETTY_PRINT));
header('Location: annuaire_entreprise.php');
exit();