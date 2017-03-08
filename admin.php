<?php
session_start();
if ($_SESSION['admin'] != 1){header('Location:/index.php');}
require_once('bddconnect.php');
require_once('fonctions.php');
require_once('header_footer.php') ;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Rogue Project</title>
</head>
<body>

<?php headerHTML(); ?>
<br>

<?php
if (!empty($_POST['ajout_news']))
{
    $erreurformulaire = validerFormulaire($_POST, ['admin_ajout_image']);

    if (empty($erreurformulaire))
    {
        $image = verifimage($_FILES['admin_ajout_image']);

        $formulaire = [

        ];
    }
}

//$formulaire = [
//    'pseudo' => 'betaween',
//    'mail' => 'betaween@mail.com',
//    'mdp' => 'betaween'
//];
//
// ajouterUtilisateur($bdd,$formulaire);

?>

<form action="" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend><h2>Ajouter une News</h2></legend>
        <label for="admin_ajout_titre">Titre de la News : </label>
        <input type="text" name="admin_ajout_titre" id="admin_ajout_titre">
        <br>

        <label for="admin_ajout_contenu">Corps de la News : </label>
        <textarea name="contenu" id="admin_ajout_contenu" cols="60" rows="10"></textarea>
        <br>

        <label for="admin_ajout_image">Image de la News : </label>
        <input type="file" name="admin_ajout_image" id="admin_ajout_image">
        <br>

        <?php if (!empty($image['erreur'])){echo $image["erreur"].'<br>';} ?>

        <input type="submit" value="Ajouter la News" name="ajout_news">
    </fieldset>
</form>

<br>
<?php footerHTML(); ?>

</body>
</html>