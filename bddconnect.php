<?php
global $bdd;
$bdd = connectBdd();

function connectBdd()
{
    $hote = "localhost";
    $name = "rogueproj";
    $user = "root";
    $pass = "";

    try {
        $bdd = new PDO('mysql:host=' . $hote . ';dbname=' . $name . ';charset=utf8', $user, $pass);
        return $bdd;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}