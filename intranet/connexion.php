<?php
session_start();

include 'scripts/fonctions.php';
parametre('img/logo1.png');

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
    <body class="bg-light">
        <div class="container vh-100 d-flex justify-content-center align-items-center">
            <div class="row w-100">
                <div class="col-md-1 d-md-flex flex-column align-items-center justify-content-center rounded-start" style="height: 800px;">
                    <a href="index.php"><img src="img/logo2.png" alt="Logo" class="img-fluid mb-2" style="max-width: 600px;"></a>
                </div>
                <div class="col-md-6 bg-white shadow rounded-end p-5 mx-auto">
                    <h1 class="text-center mb-4">Connexion</h1>
                    <form action="connexion.php" method="post">
                        <div class="mb-3">
                            <label for="utilisateur" class="form-label">Nom d\'utilisateur</label>
                            <input type="text" class="form-control" id="utilisateur" name="utilisateur" placeholder="Nom d\'utilisateur" required>
                        </div>
                        <div class="mb-3">
                            <label for="mdp" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
                        </div>';
                        if (isset($_SESSION['erreur']) && $_SESSION['erreur'] === 'Nom d\'utilisateur ou mot de passe incorrect') {
                            echo '<div class="alert alert-danger mt-1" role="alert">Nom d\'utilisateur ou mot de passe incorrect</div>';
                            unset($_SESSION['erreur']);
                        }
    echo '<div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-dark" name="submit" value="submit">Se connecter</button>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                        <span>Si vous n\'avez pas de compte :</span>
                        <a href="inscription.php" class="btn btn-outline-dark ms-2">S\'inscrire</a>
                    </div>
                </div>
            </div>
        </div>
    </body>';
}

?>