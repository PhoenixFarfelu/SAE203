<?php
session_start();
include 'scripts/fonctions.php';
parametre('img/logo1.png');

$data = read("data/annuaires/entreprise.json", $JSON=true);
$element = $data[$_POST['submit']];

echo '
<body class="container-fluid row">

    <div class="container-fluid col-sm-5 bg-white shadow rounded-end p-5" align-items: left; justify-content: center;">
    <div class="w-100">
    <div class="container-fluid">
    <a><img src="img/logo2.png" alt="Logo" class="img-fluid" style="max-width: 150px;"></a>
        <h1 class="text-center" >Inscription</h1>                                   
        <form action="traitement_modif.php" method="post" enctype="multipart/form-data" class="">

            <div class="border-bottom mb-3">

                <div class="row">
                    <!-- Nom -->
                    <div class="mb-3 col">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="'.$element['nom'].'" placeholder="Nom" required>
                    </div>

                    <!-- Prénom -->
                    <div class="mb-3 col">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="'.$element['prenom'].'" placeholder="Prénom" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- Fonction -->
                        <div class="mb-3">
                            <label for="fonction" class="form-label">Fonction</label>
                            <input type="text" class="form-control" id="fonction" name="fonction" value="'.$element['fonction'].'" placeholder="Fonction" required>
                        </div>
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="mail" class="form-label">Adresse email</label>
                            <input type="email" class="form-control" id="mail" name="email" value="'.$element['email'].'" placeholder="Adresse email" required>
                        </div>
                    </div>
                    <div class="col-sm-6 pt-5">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" accept="image/*" name="photo" id="photo" class="form-control flex-grow-1 me-2">
                    </div>
                </div>

                <!-- Bio -->
                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Bio">'.$element['bio'].'</textarea>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-dark" name="submit" value="'.$_POST['submit'].'">Modifier</button>
        </form> 
        <div class="row pt-3">
            <a href="annuaire_entreprise.php" class="btn btn-dark" class="col">Annuler</a>
        </div>       
    </div>
</body>';


