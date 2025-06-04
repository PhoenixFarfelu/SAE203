<?php
include "scripts/fonctions.php";
parametre('img/logo1.png');
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

annuaire_client();
?>