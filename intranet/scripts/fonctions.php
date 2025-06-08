<?php
function parametre($icon,$style='./scripts/style.css',$script ='./scripts/scripts.js',$author = '',$description = '' ,$keywords = ''){
    echo '
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <title>EOSIR</title>

        <!-- mette une icon a coté du titre-->
        <link rel="icon" href="'.$icon.'">
        <meta charset="UTF-8">

        <!-- Balises meta -->
        <meta name="author" content="' . $author . '">
        <meta name="description" content="' . $description . '">
        <meta name="keywords" content="' . $keywords . '">

        <!-- script bootstrap-->

        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Mon javascript -->
        <script src="'.$script.'"></script>

        <!-- Mon css -->
        <link href="'.$style.'" rel="stylesheet" type="text/css">
    </head>';
}

function read($filename,$JSON=false) {
    $file = fopen($filename,'r');
    $data = fread($file, filesize($filename));
    if ($JSON) {
        $data = json_decode($data, true);
    }
    return $data;
}

function annuaire_partenaires() {
    // if (!in_array($filename,["client","entrprise","partenaires"])) {echo "Bad name for 'filename'"; return;}
    $data = read("data/annuaires/partenaires.json", $JSON=true);
    foreach ($data as $element) {
        echo "
    nom : ".$element['nom'].",<br>
    |__description : ".$element['description'].",<br>
    |__adresse: ".$element['adresse'].",<br>
    |__telephone: ".$element['telephone']."<br>
    <br>";
    }
    
}


function annuaire_client_ameliore() {
    echo '
    <h1 class="my-4 text-center">Liste des clients</h1>
    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Adresse</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Fiche client</th>
                    </tr>
                </thead>
                <tbody>';

    $clients = json_decode(file_get_contents("data/annuaires/client.json"), true);
    foreach ($clients as $client) {
        echo '
        <tr>
            <td>' . htmlspecialchars($client['nom']) . '</td>
            <td>' . htmlspecialchars($client['prenom']) . '</td>
            <td>' . htmlspecialchars($client['adresse']) . '</td>
            <td>' . htmlspecialchars($client['telephone']) . '</td>
            <td>' . htmlspecialchars($client['email']) . '</td>
            <td>
                <form method="post" action="scripts/telecharger_fiche_client.php" style="display:inline;">
                    <input type="hidden" name="nom" value="' . htmlspecialchars($client['nom']) . '">
                    <input type="hidden" name="prenom" value="' . htmlspecialchars($client['prenom']) . '">
                    <input type="hidden" name="adresse" value="' . htmlspecialchars($client['adresse']) . '">
                    <input type="hidden" name="telephone" value="' . htmlspecialchars($client['telephone']) . '">
                    <input type="hidden" name="email" value="' . htmlspecialchars($client['email']) . '">
                    <button type="submit" class="btn btn-primary btn-sm">Télécharger</button>
                </form>
            </td>
        </tr>';
    }

    echo '
                </tbody>
            </table>
        </div>
    </div>';
}
function gestionnaire_fichier ($utilisateur,$groupe) {
    scandir('./');
}

function affiche_dossier ($dossier,$racine) {
    $chemin = explode('/',$dossier);
    // print_r($chemin);
    // echo"$chemin[1]";

    echo '<div class="container-fluid row fs-2 border-bottom"><div class="col-sm-2 text-center">';
    echo '
    <form action="test.php" method="get">
        <button type="submit" class="btn btn-warning container-fluid text-start" name="submit" value="'.$racine.'">Home</button>
    </form>'; 
    echo '</div>';
    $test = explode('/',$racine);
    $absolu = '.';
    for ($i = count($test)-1; $i < count($chemin); $i ++){
        $absolu .= "/$chemin[$i]";
        
        if (($chemin[$i] != '.')&&($chemin[$i] != $test[count($test)-1])){
            echo '
            <div class="col-sm-2">
            <form action="test.php" method="get">
                <button type="submit" class="btn btn-warning container-fluid text-start" name="submit" value="'.$absolu.'">'.$chemin[$i].'</button>
            </form>
            </div>';  
        }
    }
    echo '</div>';
    echo '<div class="container-fluid">';

    $contenu = scandir($dossier);
    array_splice($contenu,0,2); // supprime les entré : '.' et '..'
    $i = 0;
    foreach ($contenu as $value){
        $i ++;
        if (! is_dir($dossier.'/'.$value)){
            //echo '<div class="border-bottom">'.$value.'</div>';
            echo '
                 <div class="container-fluid row no-select" onmouseover="souris_dessus(this)" onmouseout="souris_sort(this)" ondblclick="telechargement(\''.$dossier.'/'.$value.'\')">
                    <div class="col-sm-1"><img src="" class="icon-dossier" alt="fichier"></div>
                    <div class="col-sm-10 ">'.$value.'</div>
                    <div class="col-sm-1 ">3 points</div>
                    <a href="'.$dossier.'/'.$value.'" id="'.$dossier.'/'.$value.'" class="d-none" download>Télécharger le fichier PDF</a>
                </div>';
        } else {
            lien_dossier($dossier.'/'.$value,$value,'file'.$i);
        }
    }
    echo '</div>';

}

function lien_dossier ($absolu,$nom,$id="") {
    echo '
    <form action="test.php" method="get">
        <button type="submit" id="'.$id.'"class="container-fluid text-start" name="submit" value="'.$absolu.'" style="display: none">'.$nom.'</button>
    </form>';
    echo '
    <div class="container-fluid row no-select" onmouseover="souris_dessus(this)" onmouseout="souris_sort(this)" ondblclick="envoie_formulaire(\''.$id.'\')">
        <div class="col-sm-1"><img src="./img/dossier.png" class="icon-dossier" alt="dossier"></div>
        <div class="col-sm-10 ">'.$nom.'</div>
        <div class="col-sm-1 ">3 points</div>
    </div>
    ';


}
function navigation() 
{
    echo('
<nav class="navbar navbar-expand-lg" style="background-color: #f8f9fa;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/SAE203/intranet/index.php">
            <img src="img/logo1.png" alt="Logo" width="100" height="100" class="d-inline-block align-text-top">
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex flex-row">
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="/SAE203/intranet/gestionnaire_fichier.php" onmouseover="agrandir(this)" onmouseout="revenir(this)">Gestionnaire de fichier</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="/SAE203/intranet/annuaire_entreprise.php" onmouseover="agrandir(this)" onmouseout="revenir(this)">Annuaire de l\'entreprise</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="/SAE203/intranet/annuaire_fournisseur_partenaire.php" onmouseover="agrandir(this)" onmouseout="revenir(this)">Annuaires des fournisseurs partenaires</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="/SAE203/intranet/annuaire_clients.php" onmouseover="agrandir(this)" onmouseout="revenir(this)">Annuaire des clients</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="/SAE203/intranet/wiki.php" onmouseover="agrandir(this)" onmouseout="revenir(this)">Wiki</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
                <span class="text-dark me-3">Bonjour, '.$_SESSION["nom"].'</span>
                <a href="/SAE203/intranet/deconnexion.php" class="btn btn-outline-dark btn-sm">Se déconnecter</a>
            </ul>
        </div>
    </div>
</nav>
    <script>
        // Sélectionner tous les liens de la navbar
    

        // Parcourir chaque lien et ajouter des gestionnaires d\'événements
        function agrandir(link){
        link.style.fontSize = \'1.5rem\'; // Agrandir la taille de la police
        link.style.transition = \'font-size 0.3s ease-in-out, color 0.3s ease-in-out\'; // Transition fluide
    
        }
        function revenir(link){
        link.style.fontSize = \'1rem\'; // Revenir à la taille normale
        link.style.color = \'\'; // Réinitialiser la couleur

        }
    
    </script>
  ');
        
    
}
?>