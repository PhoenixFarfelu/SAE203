<!-- to do list :
    - autoriser la suppression
    - creer le dossier d'enregistrement si il n'existe pas
    - sanitariser les inputs utilisateurs
    - autoriser l'overwrite (si droits accordés)
    - sécuriser les fichiers de conf (empecher l'accès aux fichiers .json)
    - Js pour reduire les dossiers
    - couper l'accès au gestionnaire de fichier (le dossier, pas la page) pou n'y acceder que par php -->

<?php
session_start();
include 'scripts/fonctions.php';
parametre('img/logo1.png');

if (!isset($_SESSION['nom'])) {
    header('Location: connexion.php');
    exit();
}
navigation();
?>
<style>
    .dropzone {
        border: 2px #20ff20;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: dashedrgb(129, 129, 129);
        position: relative;
        height: 160px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        max-width: 600px;
        margin: 0 auto;
    }

    .dropzone input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
        z-index: 1;
    }

</style>
<form action="" method="post" enctype="multipart/form-data">
    <div class="dropzone" id="unified-dropzone">
        <p>Drag your file here or click to select</p>
        <p>Accepted formats : all</p>
        <input type="file" name="file-input" id="file-input" accept=".*" required/>
    </div>
    <label for="path">absolute file folder (must start and end with "/")</label>
    <input type="text" name="path" id="path" value="/" required><br>
    <label for="path">name empty to use file's name</label>
    <input type="text" name="name" id="name"><br>
    <input type="submit" name="add_file" value="add_file">
</form>

<script>
    dropzone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        handleFile(file);
    }
</script>
<?php
    echo $_SESSION['nom'];
    if (isset($_POST['add_file'])) {
        echo "is working";
        $filetype = strtolower(pathinfo('gestionnaire_fichier'.$_POST['path'].basename($_FILES["file-input"]["name"]),PATHINFO_EXTENSION));
        $filename = $_POST['name']=="" ? $_FILES['file-input']['name'] : $_POST['name'].".".$filetype;
        echo "is working with name : $filename";
        if (isset($_SESSION['nom']) && isset($_FILES['file-input']['name'])) {
            move_uploaded_file($_FILES['file-input']['tmp_name'], 'gestionnaire_fichier'.$_POST['path'].$filename);
            echo 'gestionnaire_fichier'.$filename;
            $json = [
                'owner' => $_SESSION['nom'],
                'can_view' => [$_SESSION['nom']],
                'can_edit' => [$_SESSION['nom']],
                'can_delete' => [$_SESSION['nom']],
                'shared_with' => []
            ];

            file_put_contents("gestionnaire_fichier".$_POST['path'].$filename.".json", json_encode($json));
            echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
        } else {
            echo "<script>alert('erreur veuillez passer par votre page de profil pour modifier vos données');</script>";
            echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
        }
    }

    function afficherArborescence($dossier, $prefix = "") {
        $contenu = scandir($dossier);
        // c'est comme un `ls -l`, scandir retourne `.` et `..`, il faut les retirer
        $contenu = array_diff($contenu, [".", ".."]);

        foreach ($contenu as $index => $element) {
            $cheminComplet = $dossier."/".$element;
            $isLast = $index==array_key_last($contenu);
            $branche = "|__&nbsp";

            if (is_dir($cheminComplet) && user_can("view", $cheminComplet)) {
                $nouveauPrefix = $prefix.($isLast ? "&nbsp&nbsp&nbsp&nbsp&nbsp" : "|&nbsp&nbsp&nbsp&nbsp");
                echo $prefix.$branche."<strong>$element</strong><br>";
                afficherArborescence($cheminComplet, $nouveauPrefix);
            }
            if (is_file($cheminComplet) && user_can("view", $cheminComplet)) {
                $relativePath = htmlspecialchars($cheminComplet); // a securiser
                $filename = htmlspecialchars($element);
                echo $prefix.$branche."<a href=\"$relativePath\" download>$element</a><br>";
            }
        }
    }

    function get_file_permissions($filepath) {
        $metaFile = $filepath.".meta.json";
        if (!file_exists($metaFile)) return null;
        $json = file_get_contents($metaFile);
        return json_decode($json, true);
    }

    function user_can($action, $filepath) {
        $user = $_SESSION["nom"] ?? "";
        $role = $_SESSION["role"] ?? "guest";

        $permissions = get_file_permissions($filepath);
        if (!$permissions) return false;

        // l'admin a tous les droits
        if ($role=="admin") return true;        

        $droit = "can_".$action;
        if (isset($permissions[$droit])) {
            return (in_array($user, $permissions[$droit]) || in_array("all", $permissions[$droit]));
        }
        // en cas de probleme, seul l'owner peut tout faire
        return $permissions["owner"]==$user;
    }

    // Appel
    echo "<br>-------------------<br>";
    echo "gestionnaire_fichier/<br>";
    afficherArborescence('gestionnaire_fichier/');
    echo "<br>-------------------<br>";
?>