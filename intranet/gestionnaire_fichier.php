<?php
session_start();
include "scripts/fonctions.php";

if (isset($_POST["download"])) {
    if (isset($_POST["filename"]) && user_can("view", $_POST["filename"]) && is_file($_POST["filename"])) {
        $chemin_autorisee = realpath('gestionnaire-fichier'); // /var/www/html/intranet/gestionnaire-fichier sur la VM
        if (strpos($_POST["filename"], $chemin_autorisee) !== 0) {
            http_response_code(403);
            exit('Accès interdit.');
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($_POST["filename"]).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($_POST["filename"]));
        readfile($_POST["filename"]);
    } else {
        echo "<script>alert('un probleme est survenu');</script>";
        echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
    }
}

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
        const folderElement = event.target.closest('.text-primary');
        const folderContent = folderElement.closest('li').querySelector('ul');
        const arrow = folderElement.querySelector('span');
        if (folderContent) {
            folderContent.classList.toggle('d-none');
            arrow.textContent = folderContent.classList.contains('d-none') ? '▶' : '▼';
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

                file_put_contents("gestionnaire_fichier".$_POST["path"].$filename.".meta.json", json_encode($json, JSON_PRETTY_PRINT));
                echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
            } else {
                echo "<script>alert('un probleme est survenu');</script>";
                echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
            }
        }        
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
?>