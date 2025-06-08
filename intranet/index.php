<?php
session_start();
include 'scripts/fonctions.php';
parametre('img/logo1.png');

if (!isset($_SESSION['nom'])) {
    header('Location: connexion.php');
    exit();
}
parametre("Audalys", "PageAccueil", "accueil" );
navigation();
$users = json_decode(file_get_contents("data/utilisateur/utilisateurs.json"), true);
$clients = json_decode(file_get_contents("data/annuaires/client.json"), true);
$partenaire = json_decode(file_get_contents("data/annuaires/partenaires.json"), true);
$nb_users = count($users);
$nb_clients = count($clients);
$nb_partenaire = count($partenaire);
?>


<div class="container mt-4">
    <h1 class="text-center">Bienvenue sur Intranet</h1>
    <div class="container">
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nombres d'utilisateurs</th>
                        <th scope="col">Nombre de clients</th>
                        <th scope="col">Nombre de fournisseurs partenaires</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> <?php echo $nb_users; ?></td>
                        <td><?php echo $nb_clients; ?></td>
                        <td><?php echo $nb_partenaire; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> 

</div>