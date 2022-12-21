<?php
require_once 'inc/init.inc.php';


//------------------------------------- TRAITEMENT PHP ---------------------------------------//
if(isset($_POST['ajout_panier']))
{
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = '$_POST[id_produit]'");
    $produit = $resultat->fetch_assoc();
    // debug($produit);
    ajouterProduitDansPanier($produit['titre'], $_POST['id_produit'], $_POST['quantite'], $produit['prix']);
}
//------------------------------------- AFFICHAGE HTML ---------------------------------------//
require_once 'inc/haut.inc.php';
// debug($_SESSION);
// debug($_POST);
echo $contenu;

echo "<table class='table table-bordered text-center mt-5'>";
echo "<tr><td colspan='6' style='background: lightgrey;'><b>Panier</b></td></tr>";
echo "<tr><th>Titre</th><th>Produi</th><th>Quantité</th><th>Prix Unitaire</th><th>Action</th></tr>";
if(empty($_SESSION['panier']['id_produit']))
{
    echo "<tr><td colspan='6'>Votre panier est vide</td></tr>";
}
else
{
    for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
    {
        echo '<tr>';
            echo "<td>" . $_SESSION['panier']['titre'][$i] . "</td>";
            echo "<td>" . $_SESSION['panier']['id_produit'][$i] . "</td>";
            echo "<td>" . $_SESSION['panier']['quantite'][$i] . "</td>";
            echo "<td>" . $_SESSION['panier']['prix'][$i] . "</td>";
            echo '<td class="text-center" style="vertical-align: middle;"><button class="btn btn-dark"><a href="?action=suppression&id_produit=' . $_SESSION['panier']['id_produit'][$i] . '" Onclick="return(confirm(\'⚠ Vous êtes sur le point de supprimer ce produit. En êtes vous certain ?\'));"><i class="far fa-trash-alt"></i></a></button>';
        echo '</tr>';
    }
    echo "<tr><th colspan='4'>Total</th><td colspan='2' style='background: lightgrey;'>" . montantTotal() . " €</td></tr>";
}
echo '</table><br>';
echo "<div class='alert alert-info text-center'>💬 Règlement par CHEQUE uniquement à l'adresse suivante : 300 rue Bonaparte 75013 PARIS</div><br>";

require_once 'inc/bas.inc.php';