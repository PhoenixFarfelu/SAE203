<?php
include "scripts/fonctions.php";
parametre('img/logo1.png');
// annuaire_client();
echo '<body>';
if (isset($_GET['submit'])){
    if (explode('/',$_GET['submit'])[1] == 'gestionnaire_fichier'){
        affiche_dossier($_GET['submit']);
    } else {
        affiche_dossier('./gestionnaire_fichier/groupe/test1/test2/test3');
    }
} else {
    affiche_dossier('./gestionnaire_fichier/groupe/test1/test2/test3');
}
echo '</body>';
?>