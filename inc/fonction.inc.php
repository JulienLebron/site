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
//-------------------------------------------------
function internauteEstConnecte()
{
    if(!isset($_SESSION['membre']))
    {
        return false;
    }
    else
    {
        return true;
    }
}
//-------------------------------------------------
function internauteEstConnecteEtEstAdmin()
{
    if(internauteEstConnecte() && $_SESSION['membre']['statut'] == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}
//-------------------------------------------------
function creationPanier()
{
    if(!isset($_SESSION['panier']))
    {
        $_SESSION['panier'] = [];
        $_SESSION['panier']['titre'] = [];
        $_SESSION['panier']['id_produit'] = [];
        $_SESSION['panier']['quantite'] = [];
        $_SESSION['panier']['prix'] = [];
        $_SESSION['panier']['photo'] = [];
    }
}
//-------------------------------------------------
function ajouterProduitDansPanier($titre, $id_produit, $quantite, $prix, $photo)
{
    creationPanier();
    $position_produit = array_search($id_produit, $_SESSION['panier']['id_produit']);
    if($position_produit !== false)
    {
        $_SESSION['panier']['quantite'][$position_produit] += $quantite;
    }
    else
    {
        $_SESSION['panier']['titre'][] = $titre;
        $_SESSION['panier']['id_produit'][] = $id_produit;
        $_SESSION['panier']['quantite'][] = $quantite;
        $_SESSION['panier']['prix'][] = $prix;
        $_SESSION['panier']['photo'][] = $photo;
    }
}
//-------------------------------------------------
function montantTotal()
{
    $total = 0;
    for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
    {
        $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
    }
    return round($total, 2);
}
//-------------------------------------------------
function retirerProduitPanier($id_produit_a_supprimer)
{
    $position_produit = array_search($id_produit_a_supprimer, $_SESSION['panier']['id_produit']);
    if($position_produit !== false)
    {
        array_splice($_SESSION['panier']['titre'], $position_produit, 1);
        array_splice($_SESSION['panier']['id_produit'], $position_produit, 1);
        array_splice($_SESSION['panier']['quantite'], $position_produit, 1);
        array_splice($_SESSION['panier']['prix'], $position_produit, 1);
        array_splice($_SESSION['panier']['photo'], $position_produit, 1);
    }
}