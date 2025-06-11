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

function annuaire_client() {
    // if (!in_array($filename,["client","entrprise","partenaires"])) {echo "Bad name for 'filename'"; return;}
    $data = read("data/annuaires/client.json", $JSON=true);
    foreach ($data as $element) {
        echo "
    nom : ".$element['nom']." ".$element['prenom'].",<br>
    |__Adresse : ".$element['adresse'].",<br>
    |__Telephone : ".$element['telephone'].",<br>
    |__Email : ".$element['email'].",<br>
    |__Fiche client : 
    <form method='post' action='scripts/telecharger_fiche_client.php' style='display:inline;'>
        <input type='hidden' name='nom' value='".$element['nom']."'>
        <input type='hidden' name='prenom' value='".$element['prenom']."'>
        <input type='hidden' name='adresse' value='".$element['adresse']."'>
        <input type='hidden' name='telephone' value='".$element['telephone']."'>
        <input type='hidden' name='email' value='".$element['email']."'>
        <button type='submit' class='btn btn-primary btn-sm'>Télécharger</button>
    </form>
    <br>";
    }
    
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
function navbar (){
    echo'
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Link 1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link 2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link 3</a>
            </li>
            </ul>
        </div>
    </nav>';
}
?>