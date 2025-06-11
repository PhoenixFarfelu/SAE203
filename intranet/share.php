<?php
session_start();
include 'scripts/fonctions.php';
parametre('img/logo1.png');

echo '
    <body class="container-fluid row">

        <div class="container-fluid col-sm-5 bg-white shadow rounded-end p-5" align-items: left; justify-content: center;">
        <div class="w-100">
        <div class="container-fluid">
        <a><img src="img/logo2.png" alt="Logo" class="img-fluid" style="max-width: 150px;"></a>
            <h1 class="text-center" >Partager un fichier</h1>                                   
            <form action="ajout_employe.php" method="post" class="">

                <!-- Nom d\'utilisateur -->
                <div class="mb-3">
                    <label for="utilisateur" class="form-label">Nom d\'utilisateur</label>
                    <input type="text" class="form-control" id="utilisateur" name="utilisateur" placeholder="Nom d\'utilisateur" required>';
                
                if (isset($_SESSION['erreur']) && $_SESSION['erreur'] === 'Nom d\'utilisateur déjà utilisé') {
                    echo '<div class="alert alert-danger mt-1" role="alert">Nom d\'utilisateur déjà utilisé</div>';
                    unset($_SESSION['erreur']);
                }
                echo '
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label">Permissions</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="perm[]" id="role_admin" value="view" checked>
                        <label class="form-check-label" for="role_admin">Lecture</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="perm[]" id="role_salaries" value="edit">
                        <label class="form-check-label" for="role_salaries">Ecriture</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="perm[]" id="role_managers" value="delete">
                        <label class="form-check-label" for="role_managers">Suppression</label>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-dark" name="submit" value="submit">S\'inscrire</button>
            </form> 
            <div class="row pt-3">
                <a href="annuaire_entreprise.php" class="btn btn-dark" class="col">Annuler</a>
            </div>       
        </div>
    </body>';

if (isset($_POST["filename"]) && is_owner($_POST["filename"])) {
    if (is_file($_POST["filename"])) {
        $user = $_SESSION["nom"] ?? "";
        $permissions = get_file_permissions($_POST["filename"]);
        array_push($permissions["shared_with"], $_POST["filename"]);
        echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
    } else {
        echo "<script>alert('un probleme est survenu');</script>";
        echo '<meta http-equiv="refresh" content="0;url=gestionnaire_fichier.php">';
    }
}
?>