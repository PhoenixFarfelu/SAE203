<?php
session_start();
include 'scripts/fonctions.php';
$data = read("data/annuaires/entreprise.json", $JSON=true);

$data[$_POST['submit']]['nom'] = $_POST['nom'];
$data[$_POST['submit']]['prenom'] = $_POST['prenom'];
$data[$_POST['submit']]['fonction'] = $_POST['fonction'];
$data[$_POST['submit']]['email'] = $_POST['email'];
$data[$_POST['submit']]['bio'] = $_POST['bio'];

if (isset($_FILES["file-input"])){
    $extension = explode('.',$_FILES["photo"]["tmp_name"])[1]
    move_uploaded_file($_FILES["photo"]["tmp_name"], "data/annuaires/photo/".$filename.'.'.$extension);
}
file_put_contents("data/annuaires/entreprise.json", json_encode($data, JSON_PRETTY_PRINT));
header('Location: annuaire_entreprise.php');
exit();