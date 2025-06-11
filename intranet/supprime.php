<?php
session_start();
include 'scripts/fonctions.php';
$data = read("data/annuaires/entreprise.json", $JSON=true);
$prenom = $data[$_POST['submit']]['prenom'];
$nom = $data[$_POST['submit']]['nom'];
$username = strtolower(substr($prenom, 0, 1) . $nom);
unset($data[$_POST['submit']]);
print_r($data);
if (!empty($data[$_POST['submit']]['photo'])) {
    $photoPath = 'data/annuaires/photo/' . $data[$_POST['submit']]['photo'];
    if (file_exists($photoPath)) {
        unlink($photoPath);
    }
}
file_put_contents('data/annuaires/entreprise.json', json_encode($data, JSON_PRETTY_PRINT));

$data = read("data/utilisateur/utilisateurs.json", $JSON=true);
foreach ($data as $key => $value) {
    if (isset($value['utilisateur']) && $value['utilisateur'] == $username) {
        unset($data[$key]);
    }
}
file_put_contents('data/utilisateur/utilisateurs.json', json_encode($data, JSON_PRETTY_PRINT));

// header('Location: annuaire_entreprise.php');
// exit();
echo '<script> window.location.href = "annuaire_entreprise.php"</script>';