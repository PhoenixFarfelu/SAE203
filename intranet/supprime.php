<?php
session_start();
include 'scripts/fonctions.php';
$data = read("data/annuaires/entreprise.json", $JSON=true);
unset($data[$_POST['submit']]);
print_r($data);
file_put_contents('data/annuaires/entreprise.json', json_encode($data, JSON_PRETTY_PRINT));
header('Location: annuaire_entreprise.php');
exit();