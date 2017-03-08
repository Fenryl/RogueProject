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
    <title>Connexion Rogue Project</title>
    <link rel="stylesheet" href="CSS/reset.css">
    <link rel="stylesheet" href="CSS/global.css">
    <link rel="stylesheet" href="CSS/inscription.css">
</head>
<body>
<?php headerHTML(); ?>

<?php
if (!empty($_POST['connexion']))
{
    $erreurformulaire = validerFormulaire($_POST);

    if (empty($erreurformulaire))
    {
        $identifiants = [
            'pseudo' => ucfirst(strtolower(htmlentities($_POST['identifiant']))),
            'mdp' => htmlentities($_POST['mdp'])
        ];

        $requete = verificationMdp($bdd, $identifiants)->fetch();

        $validation = password_verify($identifiants['mdp'], $requete['mdp']);

        if ($validation)
        {
            $_SESSION['id']=$requete['id'];
            $_SESSION['admin']=$requete['admin'];
            header('Location:/index.php');
        }
        else
        {
            $message = 'Les identifiants de connexion sont incorrects';
        }
    }
}
?>

<div id="content" class="center">
    <h2 class="title">connexion</h2>
    <form method="post" action="">
        <label for="identifiant">Pseudo </label><input type="text" id="identifiant" name="identifiant" class="sign_field"
                                                       placeholder="<?php if(!empty($erreurformulaire['mdp'])){echo $erreurformulaire['mdp'];} ?><?php if(!empty($message)){echo $message;} ?>">
        <?php if(!empty($erreurformulaire['identifiant'])){echo $erreurformulaire['identifiant'];} ?>
        <label for="mdp">Mot de passe </label><input type="password" id="mdp" name="mdp" class="sign_field">

        <div id="sign_buttons">
            <input type="submit" value="connexion" name="connexion" class="sign_button">
            <input type="reset" value="annuler" class="sign_button">
        </div>
    </form>
</div>



<?php footerHTML(); ?>

</body>
</html>

