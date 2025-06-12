<?php
// session_start();
include "scripts/fonctions.php";
// print_r($_SESSION);
// annuaire_client();

// Gestionnaire de fichier
// echo '<body>';
// if (isset($_GET['submit'])){
//     if (explode('/',$_GET['submit'])[1] == 'gestionnaire_fichier'){
//         affiche_dossier($_GET['submit'],'./gestionnaire_fichier/groupe');
//     } else {
//         affiche_dossier('./gestionnaire_fichier/groupe/test1/test2/test3','./gestionnaire_fichier/groupe');
//     }
// } else {
//     affiche_dossier('./gestionnaire_fichier/groupe/test1/test2/test3','./gestionnaire_fichier/groupe');
// }
// echo '</body>';

// $test = array(1 => "hbuhbu", 2 => "ihbiubh");
// file_put_contents('data/annuaires/entreprise.json', json_encode($test, JSON_PRETTY_PRINT));
$data = read("data/annuaires/entreprise.json", $JSON=true);
$file = read("data/utilisateur/utilisateurs.json", $JSON=true);
foreach ($data as $value) {
    $temp = array(
        "nom"=>$value['nom'],
        "prenom"=> $value['prenom'],
        "utilisateur"=>strtolower(substr($value['prenom'], 0, 1) . $value['nom']),
        "motdepasse"=> '$2y$10$TAl6KgD8D/8zDmvcOvezx.ED.RUhgpNnG5Ae46V6XbqoTNc/dSINm',
        "role"=>$value['role'],
        "email"=>strtolower($value['prenom'] . '.' . $value['nom']) . '@domaine.fr'
    );
    $file[]=$temp;
}
echo '<pre>';
print_r($file);
echo '</pre>';
file_put_contents("data/utilisateur/utilisateurs.json", json_encode($file, JSON_PRETTY_PRINT));

?>