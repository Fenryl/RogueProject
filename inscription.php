<?php
session_start();
require_once('bddconnect.php') ;
require_once('fonctions.php') ;
require_once('header_footer.php') ;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Rogue Project</title>
    <link rel="stylesheet" href="CSS/reset.css">
    <link rel="stylesheet" href="CSS/global.css">
    <link rel="stylesheet" href="CSS/inscription.css">
</head>
<body>
<?php headerHTML(); ?>

<?php
if (!empty($_POST['inscription']))
{
    $erreurformulaire = validerFormulaire($_POST);

    if (empty($erreurformulaire))
    {
        $formulaire = [
            'pseudo' => ucfirst(strtolower(htmlentities($_POST['identifiant']))),
            'mail' => htmlentities($_POST['email']),
            'mdp' => htmlentities($_POST['mdp']),
            'confirmation_mdp' => htmlentities($_POST['confirmation_mdp'])
        ];

        if (strcmp($formulaire['mdp'],$formulaire['confirmation_mdp']) == 0)
        {
            ajouterUtilisateur($bdd,$formulaire);
        }
        else
        {
            $message = 'Les deux mots de passe ne correspondent pas';
        }
    }
}
?>


    <div id="content" class="center">
        <h2 class="title">inscription</h2>
        <form method="post" action="">

            <label for="identifiant">Pseudo </label><input type="text" id="identifiant" name="identifiant" class="sign_field"
            placeholder="<?php if(!empty($erreurformulaire['identifiant'])) {echo $erreurformulaire['identifiant'];}?>">


            <label for="email">Adresse mail </label><input type="email" id="email" name="email" class="sign_field"
            placeholder="<?php if(!empty($erreurformulaire['email'])){echo $erreurformulaire['email'];}?>">


            <label for="mdp">Mot de passe </label><input type="password" id="mdp" name="mdp" class="sign_field" placeholder="<?php if(!empty($erreurformulaire['mdp'])){echo $erreurformulaire['mdp'];}?>">

            <label for="confirmation_mdp">Confirmez votre mot de passe </label><input type="password" id="confirmation_mdp" name="confirmation_mdp" class="sign_field"
            placeholder="<?php if(!empty($erreurformulaire['confirmation_mdp'])){echo $erreurformulaire['confirmation_mdp'];}?><?php if(!empty($message)){echo $message;} ?>">
            <div id="sign_buttons">
                <input type="submit" value="valider" name="inscription" class="sign_button">
                <input type="reset" value="annuler" class="sign_button">
            </div>
        </form>
    </div>



<?php footerHTML(); ?>
</body>
</html>

