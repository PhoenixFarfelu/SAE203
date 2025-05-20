<?php
session_start();

include 'scripts/fonctions.php';
parametre('CoVoitVoit','images/icon.png','');

if (isset($_POST['submit'])){
    // ouverture du fichier utilisateurs.json
    $file = 'data/utilisateur/utilisateurs.json';
    $data = [];
    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
    }

    // récupération des données du formulaire
    $utilisateur = $_POST['utilisateur'];
    // $mdp = password_hash($_POST['mdp'],PASSWORD_DEFAULT);

    // authentification de l'utilisateur
    foreach ($data as $key => $value){
        if ($value['utilisateur'] == $utilisateur){
            if  (password_verify($_POST['mdp'],$value['motdepasse'])){
                $_SESSION['nom'] = $value['utilisateur'];
                $_SESSION['mail'] = $value['email'];
                $_SESSION['role'] = $value['role'];
                print_r($_SESSION);
                header('Location: index.php');
                exit();
            }
        }
    }

    $_SESSION['erreur'] = 'Nom d\'utilisateur ou mot de passe incorrect';
    header('Location: connexion.php');

} else {
    echo '
        <body class="container-fluid row">
            <div class="col-sm-2 bg-warning" style="height: 100vh; display: flex; align-items: center; justify-content: center;">
                <a href="index.php"><img src="images/icon.png" alt="Logo" class="img-fluid"></a>
            </div>

            <div class="container-fluid col-sm-4">
                <h1 class="text-center" style="margin-top: 40%;">Connexion</h1>
                <form action="connexion.php" method="post" class="">

                    <!-- Nom d\'utilisateur -->
                    <div class="mb-3">
                        <label for="utilisateur" class="form-label">Nom d\'utilisateur</label>
                        <input type="text" class="form-control" id="utilisateur" name="utilisateur" placeholder="Nom d\'utilisateur" required>
                    </div>

                    <!-- Mot de passe -->
                    <div class="mb-3">
                        <label for="mdp" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
                    </div>';
                    if (isset($_SESSION['erreur']) && $_SESSION['erreur'] === 'Nom d\'utilisateur ou mot de passe incorrect') {
                        echo '<div class="alert alert-danger mt-1" role="alert">Nom d\'utilisateur ou mot de passe incorrect</div>';
                        unset($_SESSION['erreur']);
                    }
    echo '


                    <!-- Submit -->
                    <button type="submit" class="btn btn-dark" name="submit" value="submit">Se connecter</button>
                </form>

                <!-- Boutton de redirection vers la page d\'inscription -->
                <div class="row pt-3">
                    <p class="col">Si vous n\'avez pas de compte : </p>
                    <a href="inscription.php" class="btn btn-dark" class="col">S\'inscrire</a>
                </div>
                
            </div>
        </body>';
}

?>