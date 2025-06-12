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
    echo '<div class="container_fluid p-5">';
    echo '<h1 class="text-center mb-5">Nos Partenaire</h1>';
    foreach ($data as $element) {
        echo '
        <div class="container_fluid m-3 border-bottom pb-3">
            <div class="container_fluid row">
                <div class="container_fluid col-sm-3 text-center">
                    <img src="./data/annuaires/logo/'.$element['logo'].'" alt="'.$element['name'].'" class="rounded" style="max-width:60%; height:auto;">
                </div>
                <div class="container_fluid col">
                    <h1>'.$element['name'].'</h1>
                    <p><strong>Description : </strong>'.$element['description'].'<p>
                    <div class="row">
                        <span class="col"><strong>Téléphone : </strong>'.$element['phone'].'</span>
                        <span class="col"><strong>Adresse : </strong>'.$element['address'].'</span>
                    </div>
                </div>
            </div>
        </div>';
    }
    echo '</div>';
    
}

function annuaire_employer(){
        echo '
    <h1 class="my-4 text-center">Liste des employers</h1>
    <div class="container-fluid m-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Fonction</th>
                        <th>Email</th>
                        <th>bio</th>';
        if (in_array("admin",$_SESSION['role'])){
            echo '<th>Modification</th>';
        }
                echo '</tr>
                </thead>
                <tbody>';
    $data = read("data/annuaires/entreprise.json", $JSON=true);
    foreach ($data as $key => $value) {
        echo '
            <tr>
                <td><img src="./data/annuaires/photo/'.$value['photo'].'" alt="'.$value['nom'].' '.$value['prenom'].'" class="rounded" style="max-width:20%; height:auto;"></td>
                <td>'.$value['nom'].'</td>
                <td>'.$value['prenom'].'</td>
                <td>'.$value['fonction'].'</td>
                <td>'.$value['email'].'</td>
                <td>'.$value['bio'].'</td>';
        if (in_array("admin",$_SESSION['role'])){
            echo '
                    <td>
                        <form action="/SAE203/intranet/supprime.php" method="post">
                            <button type="submit" class="btn btn-dark" name="submit" value="'.$key.'">Supprimer</button>
                        </form>
                        <form action="modifi.php" method="post">
                            <button type="submit" class="btn btn-dark" name="submit" value="'.$key.'">Modifier</button>
                        </form>
                    
                    </td>';
        }
        echo '</tr>';

    }
    echo '
        </tbody>
    </table>
    </div>

    
    ';
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
        <a class="navbar-brand" href="index.php">
            <img src="img/logo1.png" alt="Logo" width="100" height="100" class="d-inline-block align-text-top">
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex flex-row">
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="gestionnaire_fichier.php" onmouseover="agrandir(this)" onmouseout="revenir(this)">Gestionnaire de fichier</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="annuaire_entreprise.php" onmouseover="agrandir(this)" onmouseout="revenir(this)">Annuaire de l\'entreprise</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="annuaire_fournisseur_partenaire.php" onmouseover="agrandir(this)" onmouseout="revenir(this)">Annuaires des fournisseurs partenaires</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="annuaire_clients.php" onmouseover="agrandir(this)" onmouseout="revenir(this)">Annuaire des clients</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
                <span class="text-dark me-3">Bonjour, '.$_SESSION["nom"].'</span>
                <a href="deconnexion.php" class="btn btn-outline-dark btn-sm">Se déconnecter</a><!--/SAE203/intranet/deconnexion.php pas besoin de mettre le chemin absolue-->
            </ul>
        </div>
    </div>
</nav>
    <script>
        // Sélectionner tous les liens de la navbar
    

        // Parcourir chaque lien et ajouter des gestionnaires d\'événements
        function agrandir(link){
        link.style.fontSize = \'1.2rem\'; // Agrandir la taille de la police
        link.style.transition = \'font-size 0.2s ease-in-out, color 0.2s ease-in-out\'; // Transition fluide
    
        }
        function revenir(link){
        link.style.fontSize = \'1rem\'; // Revenir à la taille normale
        link.style.color = \'\'; // Réinitialiser la couleur

        }
    
    </script>
  ');
}

function afficherArborescence($dossier) {
    $contenu = scandir($dossier);
    $contenu = array_diff($contenu, [".", ".."]);
    echo '<ul class="list-group">';
    foreach ($contenu as $element) {
        $cheminComplet = $dossier."/".$element;

        if (is_dir($cheminComplet) && user_can("view", $cheminComplet)) {
            echo '<li class="list-group-item">';
            echo '<div class="d-flex justify-content-between align-items-center">';
            echo '<span class="text-primary fw-bold d-flex align-items-center" onclick="toggleFolder(event)" style="cursor: pointer;">
                    <span class="me-2">▶</span>'.$element.'
                    </span>';
            if (user_can("delete", $cheminComplet)) {
                echo '<form action="" method="post" class="d-inline">
                    <input type="text" name="filename" value="'.$cheminComplet.'" required hidden>
                    <button type="submit" name="rm" class="btn btn-link p-0" title="Supprimer">
                        <img src="img/supprimer.png" alt="Supprimer" style="width: 20px; height: 20px;">
                    </button>
                </form>';
            }
            echo '</div>';
            echo '<ul class="list-group d-none">';
            afficherArborescence($cheminComplet);
            echo '</ul>';
            echo '</li>';
        } elseif (is_file($cheminComplet) && user_can("view", $cheminComplet)) {
            $relativePath = htmlspecialchars($cheminComplet);
            echo '<li class="list-group-item">';
            echo '<div class="d-flex justify-content-between align-items-center">';
            // echo '<a href="'.$relativePath.'" download class="text-dark">'.$element.'</a>';
            echo '<form action="" method="post" class="d-inline">
                <input type="hidden" name="filename" value="'.htmlspecialchars($cheminComplet).'">
                <button type="submit" name="download" class="btn btn-link text-dark p-0">'.$element.'</button>
                </form>';
            if (user_can("delete", $cheminComplet)) {
                echo '<form action="" method="post" class="d-inline">
                    <input type="text" name="filename" value="'.$cheminComplet.'" required hidden>
                    <button type="submit" name="rm" class="btn btn-link p-0" title="Supprimer">
                        <img src="img/supprimer.png" alt="Supprimer" style="width: 20px; height: 20px;">
                    </button>
                </form>';
            }
            if (is_owner($cheminComplet)) {
                echo '<form action="share.php" method="post" class="d-inline">
                    <input type="text" name="filename" value="'.$cheminComplet.'" requiered hidden>
                    <input type="submit" name="share" value="icon à ajouter" class="bg-warning d-inline">
                </form>';
            }
            echo '</div>';
            echo '</li>';
        }
    }
    echo '</ul>';
}

function get_file_permissions($filepath) {
    $metaFile = $filepath.".meta.json";
    if (!file_exists($metaFile)) return null;
    $json = file_get_contents($metaFile);
    return json_decode($json, true);
}

function is_owner($filepath) {
    $user = $_SESSION["nom"] ?? "";
    $role = $_SESSION["role"] ?? ["guest"];

    $permissions = get_file_permissions($filepath);
    if (!$permissions) return false;

    // l'admin a tous les droits
    if (in_array("admin",$role)) return true;        

    return $permissions["owner"]==$user;
}

function user_can($action, $filepath) {
    $user = $_SESSION["nom"] ?? "";
    $role = $_SESSION["role"] ?? "guest";

    $permissions = get_file_permissions($filepath);
    if (!$permissions) return false;

    // l'admin a tous les droits
    if (in_array("admin",$role)) return true;

    $droit = "can_".$action;
    if (isset($permissions[$droit])) {
        foreach($role as $rolei) {
            if (in_array($rolei, $permissions[$droit])) return true;
        }
        if (in_array($user, $permissions[$droit])) return true;
        return (in_array("all", $permissions[$droit]));
    }
    // en cas de probleme, seul l'owner peut tout faire
    return $permissions["owner"]==$user;
}

function path_exist($path) {
    if (is_dir($path)) {
        return true;
    } else {
        $absoluteFolder = "";
        foreach (explode("/", $path) as $folder) {
            $absoluteFolder .= "/".$folder;
            $absoluteFolder = ltrim($absoluteFolder,"/");
            // echo $absoluteFolder." | ";
            if (!is_dir($absoluteFolder)) create_folder($absoluteFolder);
            // le chemin peut être crée ici mais pour une meilleure lisibilité on appelle une autre fonction
        }
        return true;
    }
}

function create_folder($path) {
    try {
        mkdir($path);
        // echo "successfuly created $path | ";
        $json = [
            "owner" => $_SESSION["nom"],
            "can_view" => [$_SESSION["nom"]],
            "can_edit" => [$_SESSION["nom"]],
            "can_delete" => [$_SESSION["nom"]],
            "shared_with" => []
        ];
        file_put_contents(rtrim($path,"/").".meta.json", json_encode($json));
        return true;
    } catch(Exception $e) {
        echo "<script>alert('un probleme est survenu : $e');</script>";
        return false;
    }
}

function sanitise_post_inputs() {
    if (isset($_POST["name"])) $_POST["name"] = htmlspecialchars(trim($_POST["name"]));
    // pour le `path`, on retire les éventuels espaces, on s'assure de la présence de "/" au debut et a la fin du `path`
    if (isset($_POST["path"])) $_POST["path"] = htmlspecialchars("/".trim(trim($_POST["path"],"/"))."/");
    if (strpos($_POST["path"], "..")) echo "<script>alert('Par mesure de sécurité, la chaine \"..\" n\'est pas autorisée');</script>";
    $chemin_autorise = realpath("gestionnaire_fichier".$_POST["path"]);
    // if ($chemin_autorise===false || strpos($chemin_autorise, realpath(__DIR__))!==0) {
    //     echo "<script>alert('Tentative de traversée détéctée !!!');</script>";
    //     die("tentative d'attaque, fermeture de la connexion");
    // }
}

function rm_dir_r($dir) {
    // echo "$dir | ";
    if (!file_exists($dir)) return true;
    if (!is_dir($dir)) return unlink($dir);
    foreach (array_diff(scandir($dir), [".", ".."]) as $item) { // scan($dir) sans les "." et ".."
        if (!rm_dir_r($dir."/".$item)) return false;
    }
    unlink("$dir.meta.json");
    return rmdir($dir);
}

?>