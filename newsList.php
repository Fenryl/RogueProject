<?php
session_start();
require_once('bddconnect.php');
require_once('fonctions.php');
require_once('header_footer.php') ;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>News Rogue Project</title>
    <link rel="stylesheet" href="CSS/reset.css">
    <link rel="stylesheet" href="CSS/global.css">
    <link rel="stylesheet" href="CSS/news.css">
</head>
<body>

<?php headerHTML("news"); ?>

    <div id="content" class="center">
        <?php
        $sql = ('SELECT news.id, titre, contenu, dateNews, id_Utilisateur, pseudo
FROM news 
INNER JOIN utilisateurs ON news.id_Utilisateur = utilisateurs.id 
ORDER BY dateNews DESC');
        $requete = $bdd->query($sql);

        while($donnees = $requete->fetch()) {

        ?>
            <div class="news">
                <h3 class="subtitle"><a href="newsDetails.php?billet=<?= $donnees['id'] ?>"><?= $donnees['titre'] ?></a></h3>

                <p><?= formatDate($donnees['dateNews']) ?>, par <?= $donnees['pseudo'] ?></p>

                <div><?=  $donnees['contenu'] ?></div>

                <a class="showMore" href="newsDetails.php?billet=<?= $donnees['id'] ?>">Afficher plus</a>
            </div>
        <?php } ?>
    </div>

<?php footerHTML(); ?>

</body>
</html>