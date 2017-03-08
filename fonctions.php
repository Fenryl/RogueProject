<?php

function verificationMdp($bdd, $identifiants)
{

    try {
        $requete = $bdd->prepare('SELECT id, mdp, admin FROM utilisateurs WHERE pseudo=:pseudo');
        $requete->execute([
            'pseudo' => $identifiants['pseudo']
        ]);

    } catch (\PDOException $e) {
        print "Error!: " . $e->getMessage() . "</br>";
    }

    return $requete;
}

function validerFormulaire($formulaire, $nonVerif = array())
{
    $erreurFormulaire = array();

    foreach ($formulaire as $cle => $donnees) {
        if (!in_array($cle, $nonVerif)) {
            if (empty($donnees)) {
                $erreurFormulaire += array($cle => 'Veuillez remplir le champ');
            }
        }
    }
    return $erreurFormulaire;
}

function ajouterUtilisateur($bdd, $formulaire){
    try {
        $requete = $bdd->prepare('INSERT INTO utilisateurs(pseudo, mail, mdp, admin) VALUES (:pseudo, :mail, :mdp, 0) ');

        $requete->execute(array(
            'mail' => $formulaire['mail'],
            'pseudo' => $formulaire['pseudo'],
            'mdp' => password_hash($formulaire['mdp'],PASSWORD_DEFAULT)
        ));
    } catch (\PDOException $e) {
        print "Error!: " . $e->getMessage() . "</br>";
    }
}

function ajouterCommentaire($bdd, $formulaire){
    try {
        $requete = $bdd->prepare('INSERT INTO commentaires(contenu, dateCommentaire, id_Utilisateur, id_News) VALUES (:contenu, :dateCommentaire, :idUtilisateur, :idNews)');
        $requete->execute(array(
            'contenu' => $formulaire['contenu'],
            'dateCommentaire' => $formulaire['dateCommentaire'],
            'idUtilisateur' => $formulaire['idUtilisateur'],
            'idNews' => $formulaire['idNews']
        ));
    } catch (\PDOException $e) {
        print "Error!: " . $e->getMessage() . "</br>";
    }
}

function supprimerCommentaire($bdd, $idCommentaire)
{
    try {

        $bdd->query('DELETE FROM commentaires WHERE id='.$idCommentaire);

    } catch (\PDOException $e) {
        print "Error!: " . $e->getMessage() . "</br>";
    }
}

function verifimage($image){
    $sortie = array();
    $sortie['chemin'] = 'Resources/No_Image_Available.png';

    if ($image['error'] !== 0) {
        switch ($image['error']) {
            case 3 :
                $sortie['erreur'] = "Code ".$image['error']." : Le fichier a été partiellement chargé";
                break;
            case 4 :
                $sortie['erreur'] = "Code ".$image['error']." : Aucun fichier n'a été choisi";
                break;
            case 6 :
                $sortie['erreur'] = "Code ".$image['error']." : Aucun répertoire temporaire";
                break;
        }



    } else {
        $nospace = str_replace(' ','',$image['name']);
        $namelower = strtolower($nospace);
        $extension = pathinfo($namelower,PATHINFO_EXTENSION);
        $extensionOk = array('jpg','jpeg','gif','png');

        if (in_array($extension,$extensionOk)){
            $destination = 'Resources/';
            $sortie['chemin'] = $destination.$namelower;
            move_uploaded_file($image['tmp_name'],$sortie['chemin']);

        } else {
            $sortie['erreur'] = "Le format du fichier uploadé n'est pas valide";
        }
    }
    return $sortie;
}

function updateImage($image, $newname){
    $nom = $newname;

    if ($image['error'] !== 0) {
        switch ($image['error']) {
            case 3 :
                echo "Le fichier a été partiellement chargé";
                break;

            case 6 :
                echo "Aucun répertoire temporaire";
                break;
        }



    } else {
        $nospace = str_replace(' ','',$image['name']);
        $namelower = strtolower($nospace);
        $extension = pathinfo($namelower,PATHINFO_EXTENSION);
        $extensionOk = array('jpg','jpeg','gif','png');

        if (in_array($extension,$extensionOk)){
            $destination = '../upload/';
            $nom = $destination.$namelower;
            move_uploaded_file($image['tmp_name'],$nom);

        } else {
            echo "Le fichier uploadé n'a pas de format de valide <br>";
        }
    }
    return $nom;
}

function formatTime($milliseconds) {
    $toSeconds = floor($milliseconds / 1000);
    $minutes = floor($toSeconds / 60) . ' min';
    $seconds = $toSeconds % 60 . ' s';
    if($seconds == 0) {
        $seconds = '';
    }
    $time = $minutes . ' ' . $seconds;
    return $time;
}

function formatDate($date, $full = false) {
    $day = substr($date, 8, 2);
    $month = substr($date, 5, 2);
    $year = substr($date, 0, 4);
    $time = '';
    if($full) {
        $hours = substr($date, -8, 2);
        $minutes = substr($date, -5, 2);
        $time = ' à ' . $hours . 'h' . $minutes;
    }
    return $day . '/' . $month . '/' . $year . $time;
}