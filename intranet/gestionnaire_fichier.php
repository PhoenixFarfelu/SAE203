<!-- to do list :
    - autoriser l'overwrite (si droits accordés)
    - sécuriser les fichiers de conf (empecher l'accès aux fichiers .json)
    - Js pour reduire les dossiers
    - couper l'accès au gestionnaire de fichier (le dossier, pas la page) pou n'y acceder que par php -->

<?php
session_start();
include "scripts/fonctions.php";
parametre("img/logo1.png");

if (!isset($_SESSION["nom"])) {
    header("Location: connexion.php");
    exit();
}
navigation();
?>
<style>
    .dropzone {
        border: 2px dashed #007bff;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: #e9ecef;
        position: relative;
        height: 160px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        max-width: 600px;
        margin: 20px auto;
    }

    .dropzone:hover {
        background-color: #d4edda;
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
<div class="container my-5">
    <h1 class="text-center text-primary mb-4">Gestionnaire de Fichiers</h1>
    <form action="" method="post" enctype="multipart/form-data" class="mb-4">
        <div class="dropzone" id="unified-dropzone">
            <p>Glissez votre fichier ici ou cliquez pour sélectionner</p>
            <p>Formats acceptés : tous</p>
            <input type="file" name="file-input" id="file-input" accept=".*" required />
        </div>
        <div class="mb-3">
            <label for="path" class="form-label">Dossier absolu :</label>
            <input type="text" name="path" id="path" class="form-control" value="/" required />
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nom (laisser vide pour utiliser le nom du fichier) :</label>
            <input type="text" name="name" id="name" class="form-control" />
        </div>
        <button type="submit" name="add_file" class="btn btn-primary">Ajouter le fichier</button>
    </form>
    <hr>
    <h2 class="text-center text-secondary my-4">Arborescence des fichiers</h2>
    <div>
        <?php afficherArborescence("gestionnaire_fichier"); ?>
    </div>
</div>
<script>
    function toggleFolder(event) {
        const folderElement = event.target;
        const folderContent = folderElement.closest('li').querySelector('ul');
        if (folderContent) {
            folderContent.classList.toggle('d-none');
        }
    }
</script>
<?php
    // echo $_SESSION["nom"];
    if (isset($_POST["add_file"])) {
        // echo "is working";
        sanitise_post_inputs();
        $filetype = strtolower(pathinfo("gestionnaire_fichier".$_POST["path"].basename($_FILES["file-input"]["name"]),PATHINFO_EXTENSION));
        $filename = $_POST["name"]=="" ? $_FILES["file-input"]["name"] : $_POST["name"].".".$filetype;
        // echo "is working with name : $filename";
        if (path_exist("gestionnaire_fichier".$_POST["path"])) {
            if (isset($_SESSION["nom"]) && isset($_FILES["file-input"]["name"])) {
                move_uploaded_file($_FILES["file-input"]["tmp_name"], "gestionnaire_fichier".$_POST["path"].$filename);
                // echo "gestionnaire_fichier".$_POST["path"].$filename;
                $json = [
                    "owner" => $_SESSION["nom"],
                    "can_view" => [$_SESSION["nom"]],
                    "can_edit" => [$_SESSION["nom"]],
                    "can_delete" => [$_SESSION["nom"]],
                    "shared_with" => []
                ];

                file_put_contents("gestionnaire_fichier".$_POST["path"].$filename.".meta.json", json_encode($json));
                // echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
            } else {
                echo "<script>alert('un probleme est survenu');</script>";
                // echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
            }
        }        
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
                echo '<span class="text-primary fw-bold" onclick="toggleFolder(event)" style="cursor: pointer;">'.$element.'</span>';
                echo '<form action="" method="post" class="d-inline">
                    <input type="text" name="filename" value="'.$cheminComplet.'" required hidden>
                    <button type="submit" name="rm" class="btn btn-link p-0" title="Supprimer">
                        <img src="img/supprimer.png" alt="Supprimer" style="width: 20px; height: 20px;">
                    </button>
                </form>';
                echo '</div>';
                echo '<ul class="list-group d-none">';
                afficherArborescence($cheminComplet);
                echo '</ul>';
                echo '</li>';
            } elseif (is_file($cheminComplet) && user_can("view", $cheminComplet)) {
                $relativePath = htmlspecialchars($cheminComplet);
                echo '<li class="list-group-item">';
                echo '<div class="d-flex justify-content-between align-items-center">';
                echo '<a href="'.$relativePath.'" download class="text-dark">'.$element.'</a>';
                echo '<form action="" method="post" class="d-inline">
                    <input type="text" name="filename" value="'.$cheminComplet.'" required hidden>
                    <button type="submit" name="rm" class="btn btn-link p-0" title="Supprimer">
                        <img src="img/supprimer.png" alt="Supprimer" style="width: 20px; height: 20px;">
                    </button>
                </form>';
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

    if (isset($_POST["rm"])) {
        if (isset($_POST["filename"]) && user_can("delete", $_POST["filename"])) {
            if (is_file($_POST["filename"])) {
                try {
                    unlink($_POST["filename"]);
                } catch(Exception $e) {}
                try {
                    unlink($_POST["filename"].".meta.json");
                } catch(Exception $e) {}
                echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
            } else if (is_dir($_POST["filename"])) {
                rm_dir_r($_POST["filename"]);
                echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
            }
        } else {
            echo "<script>alert('un probleme est survenu');</script>";
            echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
        }
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