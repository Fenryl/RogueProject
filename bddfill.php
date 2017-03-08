<?php
require_once 'bddconnect.php';

$tab = [];
for ($i=1; $i<=25; $i++) {
    for ($j=1; $j<=25; $j++) {
        $mana = array();
        $mana[0] = 0;
        $mana[1] = 0;
        $mana[2] = 0;
        for ($k=0; $k < floor($i/3); $k++) {
            $mana[rand(0, 2)] += 1;
        }
        $temps = 0;
        for ($l=0; $l < $i; $l++) {
            $temps += rand(15,60)*1000;
        }



        $value = [
            'niveau' => $i,
            'datePartie' => rand(2016,2017).'-'.rand(10,12).'-'.rand(10,31).' 00:00:00',
            'perso' => 'mage',
            'manaFeu' => $mana[0],
            'manaEau' => $mana[1],
            'manaTerre' => $mana[2],
            'temps' => $temps,
            'id_utilisateur' => rand(5,7)
        ];
        array_push($tab,$value);
    }
}

function addbdd($bdd, $tab)
{
    try {
        foreach ($tab as $data)
        {
            $requete1 = $bdd->prepare('INSERT INTO sauvegardes(id_Niveau, id_Utilisateur, etatPartie, datePartie, perso, feu, terre, eau, temps) VALUES (:niveau, :id_utilisateur, 0, :datePartie, :perso, :manaFeu, :manaTerre, :manaEau, :temps)');
            $requete1->execute([
               'niveau' => $data['niveau'],
               'id_utilisateur' => $data['id_utilisateur'],
               'datePartie' =>$data['datePartie'],
               'perso' => $data['perso'],
               'manaFeu' => $data['manaFeu'],
               'manaTerre' => $data['manaTerre'],
               'manaEau' => $data['manaEau'],
               'temps' => $data['temps'],
            ]);
            print '<br><br>';
        }
        $requete1->closeCursor();
    } catch (\PDOException $e)
    {
        print 'Error SQL : '.$e->getMessage().'<br>';
    }
}

addbdd($bdd, $tab);
print '<br>';
var_dump($tab[0]);
print 'crash?';

