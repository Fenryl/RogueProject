<?php
session_start();
require_once('bddconnect.php');
require_once('fonctions.php') ;
require_once('header_footer.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Classement Rogue Project</title>
    <link rel="stylesheet" href="CSS/reset.css">
    <link rel="stylesheet" href="CSS/global.css">
    <link rel="stylesheet" href="CSS/classement.css">
</head>
<body>

<?php headerHTML("classement"); ?>

<div id="content" class="center">
    <h2 class="title">classement</h2>
    <div id="leaderboard">
        <ul id="board_title" class="big">
            <li class="niveau">niveau</li>
            <li class="rang">rang</li>
            <li class="date">date</li>
            <li class="perso">perso</li>
            <li class="joueur">joueur</li>
            <li class="competences">compétences</li>
            <li class="temps">temps</li>
            <li class="details">détails</li>
        </ul>

        <ul id="board">
            <?php
            // je crée un tableau à 2 dimensions destiné à lister les scores pour chaque niveau atteint
            $liste = array();
            for ($j = 1; $j <= 50; $j++) {
                $liste[$j] = array();
            }

            // je réalise ma requête pour récupérer les scores de chaque partie terminée, et je trie le résultat par niveau et pas temps
            $requete = $bdd->query('SELECT sauvegardes.id, etatPartie, datePartie, perso, feu, terre, eau, temps, id_Niveau, id_Utilisateur, pseudo 
FROM sauvegardes 
INNER JOIN utilisateurs ON sauvegardes.id_Utilisateur = utilisateurs.id 
WHERE etatPartie = 0
ORDER BY id_Niveau DESC, temps ASC ');
            // j'insère les données dans mon tableau
            while ($donnees = $requete->fetch()) {
                $niveau = $donnees['id_Niveau'];
                $temps = $donnees['temps'];
                array_push($liste[$niveau], $donnees);
            }
            // j'inverse l'ordre de la liste afin d'afficher les données comme je le souhaite
            $classement = array_reverse($liste);

            // je parcours la liste pour générer l'affichage des scores
            foreach ($classement as $donnee) {
                if(!empty($donnee[0]['id_Niveau'])) {
            ?>

                <li>
                    <!-- checkbox cachée -->
                    <input type="checkbox"
                           id="<?= 'classement_checkbox_niveau_' . $donnee[0]['id_Niveau'] ?>" class="display_sublines">

                    <!-- liste contenant l'enregistrement affiché -->
                    <!-- affichage sous liste (checkbox hack) -->
                    <label for="<?= 'classement_checkbox_niveau_' . $donnee[0]['id_Niveau'] ?>" class="display_list">
                        <ul class="board_line">
                            <!-- niveau  -->
                            <li class="niveau">
                                <!-- affichage niveau -->
                                <?= $donnee[0]['id_Niveau'] ?>
                            </li>

                            <!-- affichage rang (toujours à 1) -->
                            <li class="rang">#1</li>

                            <!-- affichage de la date -->
                            <li class="date"><?= formatDate($donnee[0]['datePartie']) ?></li>

                            <!-- affichage du personnage utilisé -->
                            <li class="perso"><img src="Resources/icons/<?= $donnee[0]['perso'] ?>.png" alt="Mage"></li>

                            <!-- affichage du pseudo du joueur -->
                            <li class="joueur"><?= $donnee[0]['pseudo'] ?></li>

                            <!-- affichage du build -->
                            <li class="competences">
                                <?= $donnee[0]['feu'] ?>
                                <img src="Resources/icons/feu.png" alt="feu">
                                <?= $donnee[0]['terre'] ?>
                                <img src="Resources/icons/terre.png" alt="terre">
                                <?= $donnee[0]['eau'] ?>
                                <img src="Resources/icons/eau.png" alt="eau">
                            </li>

                            <!-- affichage du temps de jeu -->
                            <li class="temps"><?= formatTime($donnee[0]['temps']) ?></li>

                            <!-- affichage des détails de la partie-->
                            <li class="details"><a href="" class="cross"></a></li>

                        </ul>
                    </label>
                    <!-- sous-liste cachée avec les mêmes caractéristiques, contenant les autres enregistrements pour ce même niveau-->
                    <div class="sub_lines">
                        <?php for ($j = 1; $j <= min(10, count($donnee) -1); $j++) { ?>
                            <ul class="board_line">
                                <li class="niveau"><?= $donnee[$j]['id_Niveau'] ?></li>

                                <li class="rang"><?= '#' . ($j + 1) ?></li>

                                <li class="date"><?= formatDate($donnee[$j]['datePartie']) ?></li>

                                <li class="perso"><img src="Resources/icons/mage.png" alt="Mage"></li>

                                <li class="joueur"><?= $donnee[$j]['pseudo'] ?></li>

                                <li class="competences">
                                    <?= $donnee[$j]['feu'] ?>
                                    <img src="Resources/icons/feu.png" alt="feu">
                                    <?= $donnee[$j]['terre'] ?>
                                    <img src="Resources/icons/terre.png" alt="terre">
                                    <?= $donnee[$j]['eau'] ?>
                                    <img src="Resources/icons/eau.png" alt="eau">
                                </li>

                                <li class="temps"><?= formatTime($donnee[$j]['temps']) ?></li>
                                <li class="details"><a href="" class="cross"></a></li>
                            </ul>
                        <?php } ?>
                    </div>
                </li>
            <?php }} ?>
        </ul>
    </div>
</div>


<?php footerHTML(); ?>

</body>
</html>