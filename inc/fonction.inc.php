<?php
//-------------------------------------------------
function executeRequete($req)
{
    global $mysqli; // permet d'avoir accès à la variable $mysqli définie dans le fichier init.inc.php (espace global)
    $resultat = $mysqli->query($req); // on execute la requête
    if(!$resultat) // si $resultat renvoie false
    {
        // En cas d'erreur SQL on affiche un message d'erreur
        die("🛑 Une erreur est survenu sur la requête SQL. <br> Message de l'erreur : " . $mysqli->error . "<br>Code : " . $req);
    }
    // on renvoi la réponse de la bdd
    return $resultat;
}
//-------------------------------------------------
function debug($var, $mode = 1)
{
    echo '<div style="background: orange; padding: 5px;">';
    $trace = debug_backtrace(); // fonction prédéfinie retournant un tableau avec des informations comme la ligne et le fichier ou est exécuté la fonction
    $trace = array_shift($trace); // Extrait la première valeur du tableau. Retire une dimension au tableau $trace
    echo "Debug demandé dans le fichier : $trace[file] à la ligne $trace[line].";
    if($mode === 1) // en fonction du mode on fait un print_r ou un var_dump
    {
        echo '<pre>'; print_r($var); echo '</pre>';
    }
    else
    {
        echo '<pre>'; var_dump($var); echo '</pre>';
    }
    echo '</div>';
}