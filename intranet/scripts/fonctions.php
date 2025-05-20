<?php
function parametre($icon,$style = 'style.css',$script = '',$author = '',$description = '' ,$keywords = ''){
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


?>