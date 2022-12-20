<?php
require_once '../inc/init.inc.php';

//---------------------------------- TRAITEMENT PHP --------------------------------//
if(!internauteEstConnecteEtEstAdmin())
{
    header("location: ../connexion.php");
}
//---------------------------------- ENREGISTREMENT DU PRODUIT --------------------------------//
if(!empty($_POST))
{
    // debug($_POST);
    $photo_bdd = "";
    if(!empty($_FILES['photo']['name']))
    {
        $nom_photo = $_POST['reference'] . '_' . $_FILES['photo']['name'];
        $photo_bdd = RACINE_SITE . "photo/$nom_photo";
        $photo_dossier = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . "/photo/$nom_photo";
        // echo '<pre>'; print_r($_FILES); echo '</pre>';
        copy($_FILES['photo']['tmp_name'], $photo_dossier); 
    }
    foreach($_POST AS $indice => $valeur)
    {
        $_POST[$indice] = htmlentities(addslashes($valeur));
    }
    executeRequete("INSERT INTO produit (id_produit, reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES ('', '$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[public]', '$photo_bdd', '$_POST[prix]', '$_POST[stock]')");
    $contenu .= '<div class="alert alert-success text-center">✅ Le produit à bien été enregistrer en base de données !</div>';
}
//---------------------------------- LIENS GESTION PRODUIT --------------------------------//
$contenu .= '<div class="container my-4"><div class="row text-center"><div class="col-md-6"><button type="button" class="btn btn-primary"><a href="?action=affichage">Affichage des produits</a></button></div><br>';
$contenu .= '<div class="col-md-6"><button type="button" class="btn btn-primary"><a href="?action=ajout">Ajouter un produit</a></button></div></div></div><br>';
//---------------------------------- AFFICHAGE TABLEAU PRODUIT --------------------------------//
if(isset($_GET['action']) && $_GET['action'] == "affichage")
{
    $resultat = executeRequete("SELECT * FROM produit");
    $contenu .= '<h2>Affichage des Produits</h2>';
    $contenu .= 'Nombre de produit(s) dans la boutique : ' . $resultat->num_rows;

    $contenu .= '<table class="table table-bordered"><thead><tr>';
    while($colonne = $resultat->fetch_field())
    {
        $contenu .= '<th>' . $colonne->name . '</th>';
    }
    $contenu .= '<th>Editer</th>';
    $contenu .= '<th>Supprimer</th>';
    $contenu .= '</tr></thead>';

    while($ligne = $resultat->fetch_assoc())
    {
        $contenu .= '<tbody><tr>';
        foreach($ligne AS $indice => $valeur)
        {
            if($indice == "photo")
            {
                $contenu .= '<td><img src="' . $valeur . '" class="img-gestion-produit"></td>';
            }
            else
            {
                $contenu .= '<td>' . $valeur . '</td>';
            }
        }
        $contenu .= '<td class="text-center" style="vertical-align: middle;"><button class="btn btn-info"><a href="?action=modification&id_produit=' . $ligne['id_produit'] . '"><i class="far fa-edit"></i></a></button></td>';
        $contenu .= '<td class="text-center" style="vertical-align: middle;"><button class="btn btn-dark"><a href="?action=suppression&id_produit=' . $ligne['id_produit'] . '" Onclick="return(\'⚠ Vous êtes sur le point de supprimer ce produit. En êtes vous certain ?\'));"><i class="far fa-trash"></i></a></button></td>';
    }
    $contenu .= '</tbody></table><br><hr><br>';
}
//---------------------------------- AFFICHAGE HTML --------------------------------//
require_once '../inc/haut.inc.php';
echo $contenu;
?>

<div class="jumbotron text-center mt-5">
    <h2>Gestion des produits</h2>
</div>

<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="reference" class="form-label">Référence</label>
        <input type="text" class="form-control" name="reference" id="reference" placeholder="🔑 La référence du produit">
    </div>
    <div class="mb-3">
        <label for="categorie" class="form-label">Catégorie</label>
        <input type="text" class="form-control" name="categorie" id="categorie" placeholder="📑 La catégorie du produit">
    </div>
    <div class="mb-3">
        <label for="titre" class="form-label">Titre</label>
        <input type="text" class="form-control" name="titre" id="titre" placeholder="💬 La titre du produit">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="💬 La description du produit"></textarea>
    </div>
    <div class="mb-3">
        <label for="couleur" class="form-label">Couleur</label>
        <input type="text" class="form-control" name="couleur" id="couleur" placeholder="🌈 La couleur du produit">
    </div>
    <div class="mb-3">
        <label for="taille" class="form-label">Taille</label>
        <select name="taille" id="taille" class="form-select">
            <option selected>Choisir une taille</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="XXL">XXL</option>
            <option value="XXXL">XXXL</option>
            <option value="XXXXL">XXXXL</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="public" class="form-label">Public</label> <br>
        <input type="radio" name="public" value="m" checked>&nbsp; 🤵 Homme <br>
        <input type="radio" name="public" value="f">&nbsp; 👩‍💼 Femme <br>
        <input type="radio" name="public" value="mixte">&nbsp; 🤵👩‍💼 Mixte <br>
    </div>
    <div class="mb-3">
        <label for="photo" class="form-label">Photo</label>
        <input type="file" class="form-control" name="photo" id="photo">
    </div>
    <div class="mb-3">
        <label for="prix" class="form-label">Prix</label>
        <input type="text" class="form-control" name="prix" id="prix" placeholder="💲💲💲 Le prix unitaire du produit">
    </div>
    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="text" class="form-control" name="stock" id="stock" placeholder="🏭 Le stock disponible du produit">
    </div>
    <div class="mb-3 text-center mt-5">
        <button class="btn btn-primary btn-lg">Enregistrer le produit ✅</button>
    </div>
</form>

<?php 
require_once '../inc/bas.inc.php';