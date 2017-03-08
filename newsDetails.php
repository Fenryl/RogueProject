<?php
session_start();
require_once('bddconnect.php');
require_once('fonctions.php');
require_once('header_footer.php');
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
    if (!empty($_POST['envoi_commentaire'])) {
        $erreurformulaire = validerFormulaire($_POST);

        if (empty($erreurformulaire)) {
            $formulaire = [
                'contenu' => htmlspecialchars($_POST['news_comment']),
                'idNews' => htmlentities($_POST['news_id']),
                'idUtilisateur' => $_SESSION['id'],
                'dateCommentaire' => date("Y-m-d H:i:s")
            ];

            ajouterCommentaire($bdd, $formulaire);

        }
    }

    if (!empty($_POST['effacer_commentaire'])) {
        supprimerCommentaire($bdd, $_POST['commentaire_id']);
    }
    ?>

    <?php
    $sql = ('SELECT news.id, titre, contenu, dateNews, id_Utilisateur, pseudo
FROM news
INNER JOIN utilisateurs ON news.id_Utilisateur = utilisateurs.id
WHERE news.id = ?
');
    $requete = $bdd->prepare($sql);
    $requete->execute(array($_GET['billet']));
    $donnees = $requete->fetch();

    ?>
    <div class="news">
        <h3 class="subtitle"><?= $donnees['titre'] ?></h3>

        <p><?= formatDate($donnees['dateNews']) ?>, par <?= $donnees['pseudo'] ?></p>

        <div><?=  $donnees['contenu'] ?></div>

        <div id="<?= 'news_display_' . $donnees['id'] ?>">
            <form method="post" action="">
                <label for="<?= 'news_comment_'?>"></label>
                <textarea name="<?= 'news_comment'?>" id="<?= 'news_comment_' . $donnees['id'] ?>" cols="60" rows="8"
                          placeholder="Écrire un commentaire..."></textarea>
                <input type="hidden" name="news_id" value="<?= $donnees['id'] ?>">
                <input type="submit" name="envoi_commentaire" value="Poster">
            </form>
        </div>

        <div class="comment_list" id="<?= 'liste_commentaires_' . $donnees['id'] ?>">
            <?php
            $requete->closeCursor();
            $requete = $bdd->prepare('SELECT commentaires.id, contenu, dateCommentaire, id_Utilisateur, id_News, pseudo
FROM commentaires
INNER JOIN utilisateurs ON commentaires.id_Utilisateur = utilisateurs.id
WHERE id_News = ?
ORDER BY dateCommentaire ASC');
            $requete->execute(array($_GET['billet']));
            while ($commentaire = $requete->fetch()) {
                ?>
                <div class="comment">
                    <p><span class="pseudo"><?= $commentaire['pseudo'] ?></span>,
                        le <?= formatDate($commentaire['dateCommentaire'], true) ?></p>
                    <p><?= $commentaire['contenu'] ?></p>

<!--                    --><?php //if (isset($_SESSION['id'])) {
//                    if ($_SESSION['id'] == $commentaire['id_utilisateur'] || $_SESSION['admin'] == 1) { ?>
<!---->
<!--                                    <form method="post" action="">-->
<!--                                        <input type="hidden" name="commentaire_id" value="--><?//= $commentaire['id'] ?><!--">-->
<!--                                        <input type="submit" value="effacer le commentaire" name="effacer_commentaire">-->
<!--                                    </form>-->
<!---->
<!--                    --><?php //}
//                    } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php footerHTML(); ?>

</body>
</html>