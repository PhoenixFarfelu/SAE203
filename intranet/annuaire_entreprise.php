<?php
session_start();
include 'scripts/fonctions.php';
parametre('img/logo1.png');

if (!isset($_SESSION['nom'])) {
    header('Location: connexion.php');
    exit();
}
echo '<body>';
navigation();

//! Affichage de l'annuaire
echo '<h1 class="my-4 text-center">Liste des employers</h1>';

if (in_array("admin",$_SESSION['role'])){
    echo '
        <div class="text-center mb-4">
            <a href="ajout_employe.php" class="btn btn-primary">Ajouter un employé</a>
        </div>';
}
echo '
<div class="container-fluid m-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Fonction</th>
                    <th>Email</th>
                    <th>bio</th>';
    if (in_array("admin",$_SESSION['role'])){
        echo '<th>Modification</th>';
    }
            echo '</tr>
            </thead>
            <tbody>';
$data = read("data/annuaires/entreprise.json", $JSON=true);
foreach ($data as $key => $value) {
    echo '
        <tr>
            <td><img src="./data/annuaires/photo/'.$value['photo'].'" alt="'.$value['nom'].' '.$value['prenom'].'" class="rounded" style="max-width:60%; height:auto;"></td>
            <td>'.$value['nom'].'</td>
            <td>'.$value['prenom'].'</td>
            <td>'.$value['fonction'].'</td>
            <td>'.$value['email'].'</td>
            <td>'.$value['bio'].'</td>';
    if (in_array("admin",$_SESSION['role'])){
        echo '
                <td>
                    <form action="/SAE203/intranet/supprime.php" method="post">
                        <button type="submit" class="btn btn-dark" name="submit" value="'.$key.'">Supprimer</button>
                    </form>
                    <form action="modifi.php" method="post">
                        <button type="submit" class="btn btn-dark" name="submit" value="'.$key.'">Modifier</button>
                    </form>
                
                </td>';
    }
    echo '</tr>';

}
echo '
    </tbody>
</table>
</div>


';


echo '</body>';

?>
