<?php

//---------------------------------  BDD
// Connexion à la base de données
$mysqli = new mysqli("localhost", "root", "", "site");
if($mysqli->connect_error)
{
    // Affiche un message d'erreur et on termin le script en cours
    die('🛑 Un problème est survenue lors de la tentative de connexion à la base de données : ' . $mysqli->connect_error);
}
//---------------------------------  SESSION
// Démarrage de la session
session_start();
//---------------------------------  CHEMIN
// Création de constante
define("RACINE_SITE", "/site/");
//---------------------------------  VARIABLES
// On initialise la variable contenu vide pour éviter les erreurs
$contenu = '';
//---------------------------------  AUTRES INCLUSIONS
// Ici on inclu le fichier des fonctions
require_once('fonction.inc.php');