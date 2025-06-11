<?php
// session_start();
// include "scripts/fonctions.php";
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

$test = array(1 => "hbuhbu", 2 => "ihbiubh");
file_put_contents('data/annuaires/entreprise.json', json_encode($test, JSON_PRETTY_PRINT));

?>