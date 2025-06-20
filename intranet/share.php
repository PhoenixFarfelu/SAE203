<?php
session_start();
include 'scripts/fonctions.php';
parametre('img/logo1.png');

if (!isset($_SESSION['nom'])) {
    header('Location: connexion.php');
    exit();
}

if (isset($_POST["filename"])) {
        echo '
        <body class="container-fluid row"
            <div class="container-fluid col-sm-5 bg-white shadow rounded-end p-5" align-items: left; justify-content: center;">
            <div class="w-100">
            <div class="container-fluid">
            <a><img src="img/logo2.png" alt="Logo" class="img-fluid" style="max-width: 150px;"></a>
                <h1 class="text-center" >Partager un fichier</h1>                                   
                <form action="" method="post" class="">
                    <!-- Nom d\'utilisateur -->
                    <div class="mb-3">
                        <label for="utilisateur" class="form-label">Partager à </label>
                        <input type="text" class="form-control" id="utilisateur" name="utilisateur" placeholder="Nom d\'utilisateur" required>
                    </div>
                    <!-- Role -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Permissions</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="perm[]" id="view" value="view" checked>
                            <label class="form-check-label" for="view">Lecture</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="perm[]" id="edit" value="edit">
                            <label class="form-check-label" for="edit">Ecriture (et Lecture)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="perm[]" id="delete" value="delete">
                            <label class="form-check-label" for="delete">Suppression (et lecture et ecriture)</label>
                        </div>
                    </div>
                    <input type="text" name="filename" value="'.$_POST["filename"].'" requiered hidden>


                    <!-- Submit -->
                    <button type="submit" class="btn btn-dark" name="submit" value="submit">Partager</button>
                </form> 
                <div class="row pt-3">
                    <a href="gestionnaire_fichier.php" class="btn btn-dark" class="col">Annuler</a>
                </div>       
            </div>
        </body>';
} else {
    header('Location: gestionnaire_fichier.php');
    exit();
}

if (isset($_POST["submit"])) {
    if (isset($_POST["filename"]) && is_owner($_POST["filename"])) {
        if (is_file($_POST["filename"])) {
            $permissions = get_file_permissions($_POST["filename"]);
            if (!isset($_POST["perm"])) {
                echo("<script>alert('Veuillez selectionner des permissions à accorder');</script>");
                exit;
            }
            if (!in_array($_POST["utilisateur"],$permissions["shared_with"])) {
                array_push($permissions["shared_with"], $_POST["utilisateur"]);
            }
            if (!in_array($_POST["utilisateur"],$permissions["can_view"]) && in_array("view",$_POST["perm"])) {
                array_push($permissions["can_view"], $_POST["utilisateur"]);
            }
            if (!in_array($_POST["utilisateur"],$permissions["can_edit"]) && in_array("edit",$_POST["perm"])) {
                if (!in_array($_POST["utilisateur"],$permissions["can_view"])) {
                    array_push($permissions["can_view"], $_POST["utilisateur"]);
                }
                array_push($permissions["can_edit"], $_POST["utilisateur"]);
            }
            if (!in_array($_POST["utilisateur"],$permissions["can_delete"]) && in_array("delete",$_POST["perm"])) {
                if (!in_array($_POST["utilisateur"],$permissions["can_delete"])) {
                    if (!in_array($_POST["utilisateur"],$permissions["can_view"])) {
                        array_push($permissions["can_view"], $_POST["utilisateur"]);
                    }
                    array_push($permissions["can_edit"], $_POST["utilisateur"]);
                }
                array_push($permissions["can_delete"], $_POST["utilisateur"]);
            }
            file_put_contents($_POST["filename"].".meta.json", json_encode($permissions, JSON_PRETTY_PRINT));
            echo "<script>alert('fichier partagé avec succès');</script>";
            echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
        } else {
            echo "<script>alert('un probleme est survenu');</script>";
            echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
        }
    }
}
?>