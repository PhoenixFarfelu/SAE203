<?php
session_start();
include 'scripts/fonctions.php';
parametre('img/icon1.png');

if (!isset($_SESSION['nom'])) {
    header('Location: connexion.php');
    exit();
}
?>
<style>
    .dropzone {
        border: 2px #20ff20;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: dashedrgb(129, 129, 129);
        position: relative;
        height: 160px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        max-width: 600px;
        margin: 0 auto;
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
<form action="" method="post" enctype="multipart/form-data">
    <div class="dropzone" id="unified-dropzone">
        <p>Drag your file here or click to select</p>
        <p>Accepted formats : all</p>
        <input type="file" name="file-input" id="file-input" accept=".*" required/>
    </div>
    <label for="path">absolute file folder (must start and end with "/")</label>
    <input type="text" name="path" id="path" value="/" required><br>
    <label for="path">name empty to use file's name</label>
    <input type="text" name="name" id="name"><br>
    <input type="submit" name="add_file" value="add_file">
</form>

<script>
    dropzone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        handleFile(file);
    }
</script>
<?php
    // echo "php working";
    // if (isset($_POST["add_file"])) {
    //     $target_dir = "/intranet/gestionnaire_fichier/";
    //     $target_file = $target_dir . basename($_FILES["file-input"]["name"]);
    //     $uploadOk = 1;
    //     $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    //     // Check if image file is a actual image or fake image
    //     if(isset($_POST["submit"])) {
    //         echo "<script>alert('debut de l'enregistrement');</script>";
    //         if (file_exists($target_file)) {
    //             echo "Sorry, file already exists.";
    //             $uploadOk = 0;
    //         }
    //         if ($uploadOk == 0) {
    //             echo "Sorry, your file was not uploaded.";
    //         // if everything is ok, try to upload file
    //         } else {
    //             if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //                 echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    //             } else {
    //                 echo "Sorry, there was an error uploading your file.";
    //             }
    //         }
    //     }
    // }
?>

<?php
    echo $_SESSION['nom'];
    if (isset($_POST['add_file'])) {
        echo "<script>alert('debut de l'enregistrement');</script>";
        echo "is working";
        $filename = $_POST['name']=="" ? $_FILES['file-input']['name'] : $_POST['name'];
        echo "is working with name : $filename";
        if (isset($_SESSION['nom']) && isset($_FILES['file-input']['name'])) {
            move_uploaded_file($_FILES['file-input']['tmp_name'], 'gestionnaire_fichier'.$_POST['path'].$filename);
            echo 'gestionnaire_fichier'.$_POST['path'].$_FILES['file-input']['name'];
            // echo '<meta http-equiv="refresh" content="0;url=profil.php">';
        } else {
            echo "<script>alert('erreur veuillez passer par votre page de profil pour modifier vos données');</script>";
            // echo '<meta http-equiv="refresh" content="0;url=profil.php">';
        }
    }
?>