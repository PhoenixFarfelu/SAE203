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
    $mdp = password_hash($_POST['mdp'],PASSWORD_DEFAULT);
    $mail = $_POST['email'];
    $role = 'user';

    // Vérification si le nom d'utilisateur est déjà utilisé
    foreach ($data as $key => $value) {
        if ($value['utilisateur'] === $utilisateur) {
            $_SESSION['erreur'] = 'Nom d\'utilisateur déjà utilisé';
            header('Location: inscription.php');
            exit();
        }
    }

    // Ajout de l'utilisateur dans le fichier utiliosateurs.json
    $liste = array('utilisateur' => $utilisateur, 'motdepasse' => $mdp, 'email' => $mail, 'vehicule' => $vehicule, 'role' => $role);
    $data[] = $liste;
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    header('Location: connexion.php');
    exit();

} else {
    // Affichage du formulaire
    echo '
    <body class="container-fluid row">

        <div class="container-fluid col-sm-5 bg-white shadow rounded-end p-5" align-items: left; justify-content: center;">
        <div class="w-100">
        <div class="container-fluid">
        <a><img src="img/logo2.png" alt="Logo" class="img-fluid" style="max-width: 150px;"></a>
            <h1 class="text-center" >Inscription</h1>                                   
            <form action="inscription.php" method="post" class="">

                <div class="border-bottom mb-3">

                    <div class="row">
                        <!-- Nom -->
                        <div class="mb-3 col">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
                        </div>

                        <!-- Prénom -->
                        <div class="mb-3 col">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- Fonction -->
                            <div class="mb-3">
                                <label for="fonction" class="form-label">Fonction</label>
                                <input type="text" class="form-control" id="fonction" name="fonction" placeholder="Fonction" required>
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Adresse email" required>
                            </div>
                        </div>
                        <div class="col-sm-6 pt-5">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" accept="image/*" name="photo" id="photo" class="form-control flex-grow-1 me-2" required>
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Bio"></textarea>
                    </div>
                </div>


            
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

                <!-- Mot de passe -->
                <div class="mb-3">
                    <label for="mdp" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-dark" name="submit" value="submit">S\'inscrire</button>
            </form> 
            <div class="row pt-3">
                <p class="col">Si vous avez déjà un compte : </p>
                <a href="connexion.php" class="btn btn-dark" class="col">Se connecter</a>
            </div>       
        </div>
    </body>';
}
?>



